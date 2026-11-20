<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Services\Buyback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function index(Request $request): View
    {
        $agent = $request->user();

        return view('agent.index', [
            'pickups' => $agent->assignedPickups()->with(['user', 'items.material'])
                ->where('status', 'assigned')
                ->orderBy('pickup_date')->orderByRaw("FIELD(time_slot, 'morning', 'afternoon', 'evening')")
                ->get(),
            'today' => $agent->assignedPickups()->where('status', 'collected')->whereDate('collected_at', today())->count(),
            'monthKg' => (float) \App\Models\PickupItem::whereHas('pickup', fn ($q) => $q->where('agent_id', $agent->id)
                ->where('status', 'collected')->where('collected_at', '>=', now()->startOfMonth()))->sum('verified_kg'),
            'total' => $agent->assignedPickups()->where('status', 'collected')->count(),
        ]);
    }

    public function history(Request $request): View
    {
        return view('agent.history', [
            'pickups' => $request->user()->assignedPickups()->with(['user', 'items'])
                ->where('status', 'collected')->latest('collected_at')->paginate(15),
        ]);
    }

    public function show(Request $request, Pickup $pickup): View
    {
        abort_unless($pickup->agent_id === $request->user()->id, 404);

        $pickup->load(['user', 'items.material']);

        return view('agent.show', compact('pickup'));
    }

    public function collect(Request $request, Pickup $pickup, Buyback $buyback): RedirectResponse
    {
        abort_unless($pickup->agent_id === $request->user()->id, 404);

        $data = $request->validate([
            'weights' => ['required', 'array'],
            'weights.*' => ['required', 'numeric', 'min:0', 'max:5000'],
            'confirm' => ['accepted'],
        ], ['confirm.accepted' => 'Confirm that you weighed the materials in front of the household.']);

        $tx = $buyback->collect($pickup, $request->user(), $data['weights']);

        return redirect()->route('agent.dashboard')
            ->with('success', 'Pickup '.$pickup->reference.' collected. '.ugx($tx->amount).' was credited to '.$pickup->user->name.'.');
    }
}
