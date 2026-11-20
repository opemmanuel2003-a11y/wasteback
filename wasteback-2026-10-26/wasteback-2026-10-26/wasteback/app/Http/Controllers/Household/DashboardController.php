<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Models\PickupItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $byMaterial = PickupItem::query()
            ->whereHas('pickup', fn ($q) => $q->where('user_id', $user->id)->where('status', 'collected'))
            ->with('material')
            ->get()
            ->groupBy('material.name')
            ->map(fn ($items) => (float) $items->sum('verified_kg'))
            ->sortDesc();

        return view('household.dashboard', [
            'user' => $user,
            'upcoming' => $user->pickups()->with(['items.material', 'agent'])->whereIn('status', ['pending', 'assigned'])->orderBy('pickup_date')->get(),
            'recent' => $user->transactions()->latest()->take(5)->get(),
            'totalKg' => $byMaterial->sum(),
            'earned' => (float) $user->transactions()->where('type', 'credit')->sum('amount'),
            'collectedCount' => $user->pickups()->where('status', 'collected')->count(),
            'byMaterial' => $byMaterial,
        ]);
    }
}
