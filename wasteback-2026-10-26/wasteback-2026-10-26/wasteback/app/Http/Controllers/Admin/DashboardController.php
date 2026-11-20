<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Pickup;
use App\Models\PickupItem;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Kilograms collected per day for the last 14 days
        $from = today()->subDays(13);
        $daily = PickupItem::query()
            ->join('pickups', 'pickups.id', '=', 'pickup_items.pickup_id')
            ->where('pickups.status', 'collected')
            ->where('pickups.collected_at', '>=', $from)
            ->selectRaw('DATE(pickups.collected_at) as day, SUM(pickup_items.verified_kg) as kg')
            ->groupBy('day')->pluck('kg', 'day');

        $chart = collect(range(0, 13))->map(function ($i) use ($from, $daily) {
            $day = $from->copy()->addDays($i);

            return ['label' => $day->format('j/n'), 'kg' => (float) ($daily[$day->toDateString()] ?? 0)];
        });

        $agents = User::where('role', 'agent')->withCount([
            'assignedPickups as open_count' => fn ($q) => $q->where('status', 'assigned'),
            'assignedPickups as done_count' => fn ($q) => $q->where('status', 'collected'),
        ])->get();

        return view('admin.dashboard', [
            'kpi' => [
                'households' => User::where('role', 'household')->count(),
                'pending' => Pickup::where('status', 'pending')->count(),
                'kg' => (float) PickupItem::whereHas('pickup', fn ($q) => $q->where('status', 'collected'))->sum('verified_kg'),
                'paid' => (float) WalletTransaction::where('type', 'credit')->sum('amount'),
                'today' => Pickup::whereDate('created_at', today())->count(),
                'wallets' => (float) User::where('role', 'household')->sum('wallet_balance'),
            ],
            'chart' => $chart,
            'materials' => Material::where('is_active', true)->orderBy('name')->get(),
            'pending' => Pickup::with('user')->where('status', 'pending')->orderBy('pickup_date')->take(6)->get(),
            'agents' => $agents,
            'since' => Carbon::parse($from)->format('j M'),
        ]);
    }
}
