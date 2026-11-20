<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Pickup;
use App\Models\RecyclingPartner;
use App\Models\User;
use App\Services\Buyback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Demo data for the project presentation. Every demo account uses the
 * password "password" (see README). Not for a live deployment.
 */
class DatabaseSeeder extends Seeder
{
    public function run(Buyback $buyback): void
    {
        $materials = collect([
            ['PET Plastic Bottles', 'plastic', 'Clear and coloured soda and water bottles. Rinse and remove the caps.', 'bottles_pile', 600, 1000],
            ['Hard Plastic Containers', 'plastic', 'Jerrycans, basins, cooking oil and detergent containers (HDPE).', 'containers', 800, 800],
            ['Soft Plastics and Sacks', 'plastic', 'Clean polythene, sacks and plastic wrapping, kept dry.', 'plastic_bales', 300, 600],
            ['Aluminium Cans', 'metal', 'Drink cans and clean aluminium pieces. Crush them to save space.', 'metal_parts', 3500, 300],
            ['Iron and Steel Scrap', 'metal', 'Old iron sheets, rods, bicycle parts and broken tools.', 'scrap_metal', 900, 2000],
            ['Copper Wire', 'metal', 'Stripped or unstripped copper cable and wire offcuts.', 'excavator', 15000, 10],
            ['Cardboard', 'paper', 'Flattened boxes and cartons. Must be dry.', 'cardboard', 250, 1500],
            ['Office and Exercise Paper', 'paper', 'White paper, old exercise books and newspapers.', 'paper_bales', 400, 800],
            ['Glass Bottles', 'glass', 'Beer, soda and spirit bottles, whole or broken, kept separate.', 'glass', 150, 2000],
            ['Electronic Scrap', 'ewaste', 'Old phones, chargers, radios and circuit boards.', 'ewaste', 5000, 200],
        ])->map(fn ($m) => Material::create([
            'name' => $m[0],
            'slug' => \Illuminate\Support\Str::slug($m[0]),
            'category' => $m[1],
            'description' => $m[2],
            'image' => $m[3],
            'price_per_kg' => $m[4],
            'bulk_threshold_kg' => $m[5],
        ]))->keyBy('slug');

        $partners = collect([
            ['Kampala Plastics Recycling Plant', 'Namanve Industrial Park', '+256 700 000 201', 'PET, HDPE, soft plastics'],
            ['Uganda Steel and Metal Works', 'Jinja Road Industrial Area', '+256 700 000 202', 'Iron, steel, aluminium, copper'],
            ['Nile Paper Products', 'Kawempe, Kampala', '+256 700 000 203', 'Cardboard and paper'],
            ['Coca-Cola Beverages Uganda', 'Namanve, Mukono', '+256 700 000 204', 'PET bottles and aluminium cans'],
        ])->map(fn ($p) => RecyclingPartner::create([
            'name' => $p[0], 'location' => $p[1], 'contact_phone' => $p[2], 'accepts' => $p[3],
        ]));

        $admin = User::create([
            'name' => 'System Administrator', 'email' => 'admin@wasteback.ug', 'phone' => '0700000100',
            'role' => 'admin', 'zone' => 'Banda', 'address' => 'WasteBack Office, Banda Stage', 'password' => 'password',
        ]);

        $agents = collect([
            ['Okello Brian', 'agent@wasteback.ug', 'Banda'],
            ['Nansubuga Sarah', 'sarah.agent@wasteback.ug', 'Kireka'],
            ['Kato Ivan', 'ivan.agent@wasteback.ug', 'Nakawa'],
        ])->map(fn ($a, $i) => User::create([
            'name' => $a[0], 'email' => $a[1], 'phone' => '07010000'.($i + 10), 'role' => 'agent',
            'zone' => $a[2], 'address' => $a[2].', Kampala', 'password' => 'password',
        ]));

        $households = collect([
            ['Namubiru Grace', 'household@wasteback.ug', 'Banda', 'Banda Zone B, near the mosque'],
            ['Ssemwogerere Peter', 'peter@example.com', 'Banda', 'Banda Kansanga road, plot 14'],
            ['Akello Mercy', 'mercy@example.com', 'Kireka', 'Kireka Kamuli road'],
            ['Mugisha Daniel', 'daniel@example.com', 'Kyambogo', 'Kyambogo staff quarters, block C'],
            ['Nalwoga Prossy', 'prossy@example.com', 'Nakawa', 'Nakawa housing estate'],
            ['Opolot Samuel', 'samuel@example.com', 'Kasokoso', 'Kasokoso trading centre'],
            ['Birungi Esther', 'esther@example.com', 'Ntinda', 'Ntinda Kigoowa'],
            ['Wasswa Joseph', 'joseph@example.com', 'Bweyogerere', 'Bweyogerere Buto'],
        ])->map(fn ($h, $i) => User::create([
            'name' => $h[0], 'email' => $h[1], 'phone' => '07720000'.($i + 10), 'role' => 'household',
            'zone' => $h[2], 'address' => $h[3], 'password' => 'password',
        ]));

        // A history of pickups over the last six weeks, pushed through the real rules.
        $slugs = $materials->keys()->all();
        $slots = array_keys(Pickup::SLOTS);
        mt_srand(2026);
        $today = Carbon::today(); // captured before setTestNow moves the clock

        for ($i = 0; $i < 46; $i++) {
            $household = $households[$i % $households->count()];
            $daysAgo = 42 - $i;
            $date = $today->copy()->subDays(max($daysAgo, -6));

            $items = [];
            foreach ((array) array_rand(array_flip($slugs), mt_rand(1, 3)) as $slug) {
                $material = $materials[$slug];
                $kg = match ($material->category) {
                    'metal' => $material->slug === 'copper-wire' ? mt_rand(1, 4) : mt_rand(5, 40),
                    'ewaste' => mt_rand(1, 6),
                    default => mt_rand(8, 60),
                };
                $items[$material->id] = $kg;
            }

            Carbon::setTestNow($date->copy()->subDays(1)->setTime(9, 0));
            $pickup = $buyback->bookPickup($household, [
                'zone' => $household->zone,
                'address' => $household->address,
                'pickup_date' => $date->toDateString(),
                'time_slot' => $slots[$i % 3],
                'items' => $items,
            ]);

            $agent = $agents->firstWhere('zone', $household->zone) ?? $agents[$i % $agents->count()];

            if ($daysAgo <= 1) {
                // Today and upcoming: a mix of pending and assigned. The demo
                // agent account (Okello, Banda) always has work waiting.
                if ($i % 3 !== 2) {
                    $buyback->assign($pickup, $i % 2 ? $agent : $agents[0]);
                }
                continue;
            }

            if ($i % 11 === 5) {
                $buyback->cancel($pickup);
                continue;
            }

            $buyback->assign($pickup, $agent);
            Carbon::setTestNow($date->copy()->setTime(10 + $i % 6, 15));
            $weights = $pickup->items->mapWithKeys(fn ($item) => [
                $item->id => round((float) $item->estimated_kg * (mt_rand(85, 108) / 100), 1),
            ])->all();
            $buyback->collect($pickup->fresh(), $agent, $weights);

            if ($i % 4 === 3) {
                $household->refresh();
                $amount = floor((float) $household->wallet_balance * 0.6 / 1000) * 1000;
                if ($amount >= Buyback::MIN_WITHDRAWAL) {
                    Carbon::setTestNow($date->copy()->setTime(17, 30));
                    $buyback->withdraw($household, $amount, $i % 2 ? 'airtel' : 'mtn', $household->phone);
                }
            }
        }

        // Two earlier bulk dispatches so the inventory history is not empty.
        Carbon::setTestNow($today->copy()->subDays(10)->setTime(11, 0));
        foreach ([['pet-plastic-bottles', 3, 0.35], ['pet-plastic-bottles', 0, 0.3], ['iron-and-steel-scrap', 1, 0.4]] as [$slug, $partner, $share]) {
            $material = $materials[$slug];
            $kg = floor($material->stockKg() * $share);
            if ($kg > 0) {
                $buyback->dispatch($material, $admin, [
                    'recycling_partner_id' => $partners[$partner]->id,
                    'quantity_kg' => $kg,
                    // Partners pay roughly 1.6 times what households were paid.
                    'price_per_kg' => ceil($material->price_per_kg * 1.6 / 50) * 50,
                    'truck_plate' => 'UBK 4'.($partner + 21).'J',
                ]);
            }
        }
        Carbon::setTestNow();

        \App\Models\ContactMessage::create([
            'name' => 'Kyomuhendo Ruth', 'phone' => '0783000111', 'email' => 'ruth@example.com',
            'subject' => 'Collection in Kiwatule',
            'message' => 'Do you collect in Kiwatule? Our estate has a lot of plastic bottles every week.',
        ]);
    }
}
