<?php

namespace App\Services;

use App\Models\BulkDispatch;
use App\Models\Material;
use App\Models\Pickup;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * The buyback rules in one place: price quotes, pickup lifecycle,
 * the simulated wallet ledger and bulk dispatch to recycling plants.
 */
class Buyback
{
    public const MIN_WITHDRAWAL = 2000;

    /**
     * @param  array<int|string, float|string|null>  $quantities  material id => kg
     * @return array{lines: array<int, array<string, mixed>>, total: float, kg: float}
     */
    public function quote(array $quantities): array
    {
        $quantities = collect($quantities)
            ->map(fn ($kg) => round((float) $kg, 2))
            ->filter(fn ($kg) => $kg > 0);

        $materials = Material::where('is_active', true)
            ->whereIn('id', $quantities->keys())
            ->get()->keyBy('id');

        $lines = [];
        foreach ($quantities as $id => $kg) {
            if (! $material = $materials->get($id)) {
                continue;
            }
            $lines[] = [
                'material' => $material,
                'kg' => $kg,
                'price' => (float) $material->price_per_kg,
                'amount' => round($kg * (float) $material->price_per_kg, 2),
            ];
        }

        return [
            'lines' => $lines,
            'total' => round(array_sum(array_column($lines, 'amount')), 2),
            'kg' => round(array_sum(array_column($lines, 'kg')), 2),
        ];
    }

    /** @param  array<string, mixed>  $data */
    public function bookPickup(User $household, array $data): Pickup
    {
        $quote = $this->quote($data['items'] ?? []);

        if (empty($quote['lines'])) {
            throw ValidationException::withMessages([
                'items' => 'Add the weight of at least one material you want to sell.',
            ]);
        }

        return DB::transaction(function () use ($household, $data, $quote) {
            $pickup = Pickup::create([
                'reference' => $this->reference('PU'),
                'user_id' => $household->id,
                'zone' => $data['zone'],
                'address' => $data['address'],
                'pickup_date' => $data['pickup_date'],
                'time_slot' => $data['time_slot'],
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
                'estimated_total' => $quote['total'],
            ]);

            foreach ($quote['lines'] as $line) {
                $pickup->items()->create([
                    'material_id' => $line['material']->id,
                    'estimated_kg' => $line['kg'],
                    'price_per_kg' => $line['price'],
                ]);
            }

            return $pickup;
        });
    }

    public function assign(Pickup $pickup, User $agent): void
    {
        if (! $agent->isAgent()) {
            throw ValidationException::withMessages(['agent_id' => 'Choose a field agent.']);
        }
        if (! in_array($pickup->status, ['pending', 'assigned'], true)) {
            throw ValidationException::withMessages(['agent_id' => 'This pickup can no longer be reassigned.']);
        }

        $pickup->update(['agent_id' => $agent->id, 'status' => 'assigned', 'assigned_at' => now()]);
    }

    public function cancel(Pickup $pickup): void
    {
        if (! in_array($pickup->status, ['pending', 'assigned'], true)) {
            throw ValidationException::withMessages(['pickup' => 'Only pickups that have not been collected can be cancelled.']);
        }

        $pickup->update(['status' => 'cancelled']);
    }

    /**
     * The agent weighs each material on site. Payment uses the price locked in
     * at booking, credits the household wallet and the stock joins the
     * inventory pool, all in one transaction.
     *
     * @param  array<int|string, float|string|null>  $weights  pickup item id => verified kg
     */
    public function collect(Pickup $pickup, User $agent, array $weights): WalletTransaction
    {
        return DB::transaction(function () use ($pickup, $agent, $weights) {
            $pickup = Pickup::whereKey($pickup->id)->lockForUpdate()->firstOrFail();

            if ($pickup->status !== 'assigned' || $pickup->agent_id !== $agent->id) {
                throw ValidationException::withMessages(['weights' => 'This pickup is not assigned to you or was already collected.']);
            }

            $total = 0.0;
            foreach ($pickup->items as $item) {
                $kg = round(max(0, (float) ($weights[$item->id] ?? 0)), 2);
                $item->update(['verified_kg' => $kg]);
                $total += $kg * (float) $item->price_per_kg;
            }
            $total = round($total, 2);

            if ($total <= 0) {
                throw ValidationException::withMessages(['weights' => 'Enter the weighed kilograms for at least one material.']);
            }

            $pickup->update(['status' => 'collected', 'verified_total' => $total, 'collected_at' => now()]);

            $household = User::whereKey($pickup->user_id)->lockForUpdate()->firstOrFail();
            $household->wallet_balance = round((float) $household->wallet_balance + $total, 2);
            $household->save();

            return WalletTransaction::create([
                'reference' => $this->reference('TX'),
                'user_id' => $household->id,
                'pickup_id' => $pickup->id,
                'type' => 'credit',
                'amount' => $total,
                'balance_after' => $household->wallet_balance,
                'description' => 'Payment for pickup '.$pickup->reference.' ('.number_format($pickup->items->sum('verified_kg'), 1).' kg)',
            ]);
        });
    }

    /** Simulated cash out. No real mobile money API is called. */
    public function withdraw(User $user, float $amount, string $channel, string $phone): WalletTransaction
    {
        return DB::transaction(function () use ($user, $amount, $channel, $phone) {
            $user = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $amount = round($amount, 2);

            if ($amount < self::MIN_WITHDRAWAL) {
                throw ValidationException::withMessages(['amount' => 'The minimum withdrawal is UGX '.number_format(self::MIN_WITHDRAWAL).'.']);
            }
            if ($amount > (float) $user->wallet_balance) {
                throw ValidationException::withMessages(['amount' => 'You cannot withdraw more than your wallet balance.']);
            }

            $user->wallet_balance = round((float) $user->wallet_balance - $amount, 2);
            $user->save();

            return WalletTransaction::create([
                'reference' => $this->reference('WD'),
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'balance_after' => $user->wallet_balance,
                'channel' => $channel,
                'phone' => $phone,
                'description' => 'Withdrawal to '.(WalletTransaction::CHANNELS[$channel] ?? $channel).' '.$phone.' (simulated)',
            ]);
        });
    }

    /** @param  array<string, mixed>  $data */
    public function dispatch(Material $material, User $admin, array $data): BulkDispatch
    {
        return DB::transaction(function () use ($material, $admin, $data) {
            Material::whereKey($material->id)->lockForUpdate()->first();
            $stock = $material->stockKg();
            $kg = round((float) $data['quantity_kg'], 2);

            if ($kg > $stock) {
                throw ValidationException::withMessages([
                    'quantity_kg' => 'Only '.number_format($stock, 2).' kg of '.$material->name.' is in stock.',
                ]);
            }

            return BulkDispatch::create([
                'reference' => $this->reference('BD'),
                'material_id' => $material->id,
                'recycling_partner_id' => $data['recycling_partner_id'],
                'created_by' => $admin->id,
                'quantity_kg' => $kg,
                'price_per_kg' => $price = round((float) ($data['price_per_kg'] ?? 0), 2),
                'amount' => round($kg * $price, 2),
                'truck_plate' => $data['truck_plate'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        });
    }

    public function reference(string $prefix): string
    {
        return $prefix.'-'.now()->format('ymd').'-'.strtoupper(Str::random(5));
    }
}
