<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Pickup;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuybackFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    private function role(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function test_public_pages_render(): void
    {
        foreach (['/', '/about', '/services', '/prices', '/how-it-works', '/contact', '/login', '/register'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_pages_contain_no_emoji_or_em_dashes(): void
    {
        foreach (['/', '/about', '/services', '/prices', '/how-it-works', '/contact'] as $url) {
            $html = $this->get($url)->getContent();
            $this->assertStringNotContainsString("\u{2014}", $html, "Em dash on {$url}");
            $this->assertDoesNotMatchRegularExpression('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', $html, "Emoji on {$url}");
        }
    }

    public function test_every_portal_page_renders_for_its_role(): void
    {
        $household = $this->role('household@wasteback.ug');
        foreach (['/household', '/household/pickups', '/household/pickups/new', '/household/wallet', '/profile'] as $url) {
            $this->actingAs($household)->get($url)->assertOk();
        }
        $this->actingAs($household)->get('/household/pickups/'.$household->pickups()->first()->id)->assertOk();

        $agent = $this->role('agent@wasteback.ug');
        foreach (['/agent', '/agent/history'] as $url) {
            $this->actingAs($agent)->get($url)->assertOk();
        }

        $admin = $this->role('admin@wasteback.ug');
        foreach (['/admin', '/admin/pickups', '/admin/pickups?status=pending', '/admin/inventory', '/admin/materials',
            '/admin/materials/'.Material::value('id').'/edit', '/admin/transactions', '/admin/users', '/admin/users/new', '/admin/messages',
            '/admin/pickups/'.Pickup::first()->id] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_roles_cannot_enter_other_portals(): void
    {
        $this->actingAs($this->role('household@wasteback.ug'))->get('/admin')->assertForbidden();
        $this->actingAs($this->role('agent@wasteback.ug'))->get('/household')->assertForbidden();
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_household_cannot_view_another_households_pickup(): void
    {
        $other = Pickup::where('user_id', '!=', $this->role('household@wasteback.ug')->id)->first();
        $this->actingAs($this->role('household@wasteback.ug'))->get('/household/pickups/'.$other->id)->assertNotFound();
    }

    public function test_full_buyback_flow_pays_wallet_and_fills_inventory(): void
    {
        $household = $this->role('household@wasteback.ug');
        $agent = $this->role('agent@wasteback.ug');
        $admin = $this->role('admin@wasteback.ug');
        $pet = Material::where('slug', 'pet-plastic-bottles')->first(); // 600 per kg
        $stockBefore = $pet->stockKg();
        $balanceBefore = (float) $household->wallet_balance;

        // 1. Household books 20 kg of PET
        $this->actingAs($household)->post('/household/pickups', [
            'items' => [$pet->id => 20],
            'zone' => 'Banda', 'address' => 'Test address',
            'pickup_date' => today()->addDay()->toDateString(), 'time_slot' => 'morning',
        ])->assertRedirect();
        $pickup = Pickup::latest('id')->first();
        $this->assertSame('pending', $pickup->status);
        $this->assertEquals(12000, (float) $pickup->estimated_total);

        // A later price change must not affect this booking
        $pet->update(['price_per_kg' => 1000]);

        // 2. Admin dispatches it to the agent
        $this->actingAs($admin)->patch("/admin/pickups/{$pickup->id}/assign", ['agent_id' => $agent->id])->assertRedirect();
        $this->assertSame('assigned', $pickup->fresh()->status);

        // 3. Agent weighs 18.5 kg and confirms
        $item = $pickup->items()->first();
        $this->actingAs($agent)->post("/agent/pickups/{$pickup->id}/collect", [
            'weights' => [$item->id => 18.5], 'confirm' => 1,
        ])->assertRedirect('/agent');

        $pickup->refresh();
        $this->assertSame('collected', $pickup->status);
        $this->assertEquals(11100, (float) $pickup->verified_total);
        $this->assertEquals($balanceBefore + 11100, (float) $household->fresh()->wallet_balance);
        $this->assertEqualsWithDelta($stockBefore + 18.5, $pet->stockKg(), 0.001);

        // Collecting twice is refused
        $this->actingAs($agent)->post("/agent/pickups/{$pickup->id}/collect", [
            'weights' => [$item->id => 18.5], 'confirm' => 1,
        ])->assertSessionHasErrors('weights');

        // 4. Household withdraws, cannot overdraw
        $balance = (float) $household->fresh()->wallet_balance;
        $this->actingAs($household)->post('/household/wallet/withdraw', [
            'amount' => $balance + 1000, 'channel' => 'mtn', 'phone' => '0772000010',
        ])->assertSessionHasErrors('amount');
        $this->actingAs($household)->post('/household/wallet/withdraw', [
            'amount' => 5000, 'channel' => 'mtn', 'phone' => '0772000010',
        ])->assertSessionHasNoErrors();
        $this->assertEquals($balance - 5000, (float) $household->fresh()->wallet_balance);

        // 5. Admin cannot dispatch more than is in stock
        $stock = $pet->stockKg();
        $this->actingAs($admin)->post('/admin/inventory/dispatch', [
            'material_id' => $pet->id, 'recycling_partner_id' => \App\Models\RecyclingPartner::value('id'), 'quantity_kg' => $stock + 1, 'price_per_kg' => 1000,
        ])->assertSessionHasErrors('quantity_kg');
        $this->actingAs($admin)->post('/admin/inventory/dispatch', [
            'material_id' => $pet->id, 'recycling_partner_id' => \App\Models\RecyclingPartner::value('id'), 'quantity_kg' => 10, 'price_per_kg' => 1000,
        ])->assertSessionHasNoErrors();
        $this->assertEquals(10000, \App\Models\BulkDispatch::latest('id')->value('amount'));
        $this->assertEqualsWithDelta($stock - 10, $pet->stockKg(), 0.001);
    }

    public function test_other_agent_cannot_collect(): void
    {
        $pickup = Pickup::where('status', 'assigned')->first();
        $other = User::where('role', 'agent')->where('id', '!=', $pickup->agent_id)->first();

        $this->actingAs($other)->post("/agent/pickups/{$pickup->id}/collect", [
            'weights' => [$pickup->items->first()->id => 5], 'confirm' => 1,
        ])->assertNotFound();
    }

    public function test_household_registration_and_contact_form(): void
    {
        $this->post('/register', [
            'name' => 'Test Seller', 'email' => 'seller@example.com', 'phone' => '0772555666',
            'zone' => 'Banda', 'address' => 'Banda', 'password' => 'secret123', 'password_confirmation' => 'secret123',
        ])->assertRedirect('/household');
        $this->assertSame('household', User::where('email', 'seller@example.com')->value('role'));

        $this->post('/logout');
        $this->post('/contact', [
            'name' => 'Visitor', 'phone' => '0772111222', 'subject' => 'Other', 'message' => 'Hello',
        ])->assertSessionHas('success');
    }
}
