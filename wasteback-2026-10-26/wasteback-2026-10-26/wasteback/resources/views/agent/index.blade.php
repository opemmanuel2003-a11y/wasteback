@extends('layouts.portal', ['title' => 'Collection List'])

@section('heading', 'Collection List')

@section('content')
<div class="kpis">
    <div class="kpi feature"><span class="ico"><x-icon name="truck" size="24" /></span><div><small>Waiting for you</small><strong>{{ $pickups->count() }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="check-circle" size="24" /></span><div><small>Collected today</small><strong>{{ $today }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="scale" size="24" /></span><div><small>Weighed this month</small><strong>{{ kg($monthKg) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="recycle" size="24" /></span><div><small>All-time collections</small><strong>{{ $total }}</strong></div></div>
</div>

<section class="panel">
    <div class="panel-head"><h2>Assigned pickups</h2></div>
    @forelse ($pickups as $pickup)
        <div class="panel-body" style="border-bottom:1px solid var(--line)">
            <div class="gap-row" style="justify-content:space-between;align-items:flex-start">
                <div>
                    <div class="gap-row">
                        <strong>{{ $pickup->pickup_date->isToday() ? 'Today' : $pickup->pickup_date->format('D, j M') }}</strong>
                        <span class="chip">{{ $pickup->slotLabel() }}</span>
                        @if ($pickup->pickup_date->isPast() && ! $pickup->pickup_date->isToday())<span class="status status-pending">Overdue</span>@endif
                    </div>
                    <p class="mb-0" style="margin-top:8px"><strong>{{ $pickup->user->name }}</strong>, <a href="tel:{{ $pickup->user->phone }}" class="lime-text">{{ $pickup->user->phone }}</a></p>
                    <p class="muted mb-0" style="font-size:14px">{{ $pickup->zone }}: {{ $pickup->address }}</p>
                    <p class="muted mb-0" style="font-size:14px">{{ $pickup->items->map(fn ($i) => $i->material->name.' ('.kg($i->estimated_kg).')')->implode(', ') }}</p>
                </div>
                <a href="{{ route('agent.pickups.show', $pickup) }}" class="btn btn-lime btn-sm"><x-icon name="scale" size="16" /> Weigh and Collect</a>
            </div>
        </div>
    @empty
        <div class="empty"><x-icon name="check-circle" size="40" /><p class="mb-0">No pickups assigned to you right now.</p></div>
    @endforelse
</section>
@endsection
