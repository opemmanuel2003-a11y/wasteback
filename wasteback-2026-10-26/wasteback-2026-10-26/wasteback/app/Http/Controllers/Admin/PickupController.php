<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Models\User;
use App\Services\Buyback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function __construct(private Buyback $buyback) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $zone = $request->query('zone');
        $search = trim((string) $request->query('q'));

        $pickups = Pickup::with(['user', 'agent', 'items'])
            ->when(in_array($status, Pickup::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->when(in_array($zone, config('site.zones'), true), fn ($q) => $q->where('zone', $zone))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('reference', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%"))))
            ->orderByRaw("FIELD(status, 'pending', 'assigned', 'collected', 'cancelled')")
            ->orderBy('pickup_date', $status === 'collected' ? 'desc' : 'asc')
            ->paginate(15)->withQueryString();

        return view('admin.pickups.index', [
            'pickups' => $pickups,
            'status' => $status,
            'zone' => $zone,
            'search' => $search,
            'agents' => $this->agents(),
        ]);
    }

    public function show(Pickup $pickup): View
    {
        $pickup->load(['user', 'agent', 'items.material']);

        return view('admin.pickups.show', ['pickup' => $pickup, 'agents' => $this->agents()]);
    }

    public function assign(Request $request, Pickup $pickup): RedirectResponse
    {
        $data = $request->validate(['agent_id' => ['required', 'exists:users,id']]);
        $agent = User::findOrFail($data['agent_id']);

        $this->buyback->assign($pickup, $agent);

        return back()->with('success', 'Pickup '.$pickup->reference.' dispatched to '.$agent->name.'.');
    }

    public function cancel(Pickup $pickup): RedirectResponse
    {
        $this->buyback->cancel($pickup);

        return back()->with('success', 'Pickup '.$pickup->reference.' was cancelled.');
    }

    private function agents()
    {
        return User::where('role', 'agent')->where('is_active', true)->orderBy('name')->get();
    }
}
