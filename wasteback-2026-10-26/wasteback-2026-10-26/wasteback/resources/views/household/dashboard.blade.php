@extends('layouts.portal', ['title' => 'My Dashboard'])

@section('heading', 'Hello, '.explode(' ', $user->name)[0])

@section('content')
<div class="quick-actions">
    <a href="{{ route('household.pickups.create') }}" class="btn btn-lime"><x-icon name="plus" size="18" /> Book a Pickup</a>
    <a href="{{ route('household.wallet') }}" class="btn btn-outline"><x-icon name="wallet" size="18" /> Withdraw Money</a>
    <a href="{{ route('prices') }}" class="btn btn-outline"><x-icon name="coins" size="18" /> Today's Prices</a>
</div>

<div class="kpis">
    <div class="kpi feature"><span class="ico"><x-icon name="wallet" size="24" /></span><div><small>Wallet balance</small><strong>{{ ugx($user->wallet_balance) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="coins" size="24" /></span><div><small>Total earned</small><strong>{{ ugx($earned) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="recycle" size="24" /></span><div><small>Recycled</small><strong>{{ kg($totalKg) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="truck" size="24" /></span><div><small>Completed pickups</small><strong>{{ $collectedCount }}</strong></div></div>
</div>

<div class="grid-2">
    <div>
        <section class="panel">
            <div class="panel-head">
                <h2>Upcoming pickups</h2>
                <a href="{{ route('household.pickups.index') }}" class="btn btn-sm btn-outline">View all</a>
            </div>
            @forelse ($upcoming as $pickup)
                <div class="panel-body" style="border-bottom:1px solid var(--line)">
                    <div class="gap-row" style="justify-content:space-between">
                        <div>
                            <strong>{{ $pickup->pickup_date->format('D, j M Y') }}</strong> <span class="muted">{{ $pickup->slotLabel() }}</span><br>
                            <small class="muted">{{ $pickup->reference }}: {{ $pickup->items->map(fn ($i) => $i->material->name)->implode(', ') }}</small>
                        </div>
                        <div class="gap-row">
                            <x-status :value="$pickup->status" />
                            <a href="{{ route('household.pickups.show', $pickup) }}" class="btn btn-sm btn-dark">Details</a>
                        </div>
                    </div>
                    @if ($pickup->agent)
                        <p class="muted mb-0" style="margin-top:8px;font-size:14px">Agent: {{ $pickup->agent->name }}, {{ $pickup->agent->phone }}</p>
                    @endif
                </div>
            @empty
                <div class="empty">
                    <x-icon name="calendar" size="40" />
                    <p>No pickups booked. Sort your scrap and book a collection.</p>
                    <a href="{{ route('household.pickups.create') }}" class="btn btn-lime btn-sm">Book a Pickup</a>
                </div>
            @endforelse
        </section>

        <section class="panel">
            <div class="panel-head"><h2>Recent wallet activity</h2><a href="{{ route('household.wallet') }}" class="btn btn-sm btn-outline">Open wallet</a></div>
            @include('household.partials.transactions', ['transactions' => $recent])
        </section>
    </div>

    <section class="panel">
        <div class="panel-head"><h2>What you have recycled</h2></div>
        <div class="panel-body">
            @php $max = max($byMaterial->max() ?? 0, 1); @endphp
            @forelse ($byMaterial as $name => $value)
                <div class="pool-row">
                    <div class="top"><strong>{{ $name }}</strong><span>{{ kg($value) }}</span></div>
                    <div class="progress"><span style="width:{{ round($value / $max * 100) }}%"></span></div>
                </div>
            @empty
                <p class="muted mb-0">Your recycled materials will show here after your first collection.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
