<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Pickup;
use App\Services\Buyback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function __construct(private Buyback $buyback) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');

        $pickups = $request->user()->pickups()
            ->with('items')
            ->when(in_array($status, Pickup::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->latest('pickup_date')->latest('id')
            ->paginate(12)->withQueryString();

        return view('household.pickups.index', compact('pickups', 'status'));
    }

    public function create(Request $request): View
    {
        return view('household.pickups.create', [
            'materials' => Material::where('is_active', true)->orderBy('category')->orderBy('name')->get(),
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'numeric', 'min:0', 'max:5000'],
            'zone' => ['required', Rule::in(config('site.zones'))],
            'address' => ['required', 'string', 'max:200'],
            'pickup_date' => ['required', 'date', 'after_or_equal:today', 'before:+31 days'],
            'time_slot' => ['required', Rule::in(array_keys(Pickup::SLOTS))],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'pickup_date.after_or_equal' => 'Choose today or a later date.',
            'pickup_date.before' => 'Pickups can be booked up to 30 days ahead.',
        ]);

        $pickup = $this->buyback->bookPickup($request->user(), $data);

        return redirect()->route('household.pickups.show', $pickup)
            ->with('success', 'Pickup '.$pickup->reference.' is booked. We will assign an agent in your zone shortly.');
    }

    public function show(Request $request, Pickup $pickup): View
    {
        abort_unless($pickup->user_id === $request->user()->id, 404);

        $pickup->load(['items.material', 'agent']);

        return view('household.pickups.show', compact('pickup'));
    }

    public function cancel(Request $request, Pickup $pickup): RedirectResponse
    {
        abort_unless($pickup->user_id === $request->user()->id, 404);

        $this->buyback->cancel($pickup);

        return back()->with('success', 'Pickup '.$pickup->reference.' was cancelled.');
    }
}
