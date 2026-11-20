@extends('layouts.portal', ['title' => 'Admin Dashboard'])

@section('heading', 'Dashboard')

@section('content')
<div class="kpis">
    <div class="kpi feature"><span class="ico"><x-icon name="recycle" size="24" /></span><div><small>Total collected</small><strong>{{ kg($kpi['kg']) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="coins" size="24" /></span><div><small>Paid to households</small><strong>{{ ugx($kpi['paid']) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="users" size="24" /></span><div><small>Households</small><strong>{{ number_format($kpi['households']) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="alert" size="24" /></span><div><small>Pickups awaiting dispatch</small><strong>{{ $kpi['pending'] }}</strong></div></div>
</div>

<div class="grid-2">
    <div>
        <section class="panel">
            <div class="panel-head"><h2>Kilograms collected, last 14 days</h2><span class="muted" style="font-size:13px">Since {{ $since }}</span></div>
            <div class="panel-body">
                @php $peak = max($chart->max('kg'), 1); @endphp
                <div class="bars" role="img" aria-label="Daily collected kilograms">
                    @foreach ($chart as $day)
                        <div class="bar" title="{{ $day['label'] }}: {{ kg($day['kg']) }}">
                            <em>{{ $day['kg'] > 0 ? round($day['kg']) : '' }}</em>
                            <span style="height:{{ max(2, round($day['kg'] / $peak * 150)) }}px"></span>
                            <small>{{ $day['label'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head"><h2>Pickups awaiting dispatch</h2><a href="{{ route('admin.pickups.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline">Open dispatch</a></div>
            @if ($pending->isEmpty())
                <div class="empty"><x-icon name="check-circle" size="40" /><p class="mb-0">Every pickup has an agent.</p></div>
            @else
                <div class="table-wrap">
                    <table class="table">
                        <thead><tr><th>Reference</th><th>Household</th><th>Area</th><th>Date</th><th class="text-right">Estimate</th><th></th></tr></thead>
                        <tbody>
                            @foreach ($pending as $pickup)
                                <tr>
                                    <td><strong>{{ $pickup->reference }}</strong></td>
                                    <td>{{ $pickup->user->name }}</td>
                                    <td>{{ $pickup->zone }}</td>
                                    <td>{{ $pickup->pickup_date->format('j M') }}, {{ $pickup->time_slot }}</td>
                                    <td class="text-right">{{ ugx($pickup->estimated_total) }}</td>
                                    <td class="text-right"><a href="{{ route('admin.pickups.show', $pickup) }}" class="btn btn-sm btn-lime">Assign</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="panel">
            <div class="panel-head"><h2>Field agents</h2><a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-outline"><x-icon name="plus" size="15" /> Add agent</a></div>
            <div class="table-wrap">
                <table class="table">
                    <thead><tr><th>Agent</th><th>Zone</th><th class="text-right">Open</th><th class="text-right">Completed</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($agents as $agent)
                            <tr>
                                <td><strong>{{ $agent->name }}</strong><br><small class="muted">{{ $agent->phone }}</small></td>
                                <td>{{ $agent->zone }}</td>
                                <td class="text-right">{{ $agent->open_count }}</td>
                                <td class="text-right">{{ $agent->done_count }}</td>
                                <td><x-status :value="$agent->is_active ? 'active' : 'inactive'" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div>
        <section class="panel">
            <div class="panel-head"><h2>B2B inventory pool</h2><a href="{{ route('admin.inventory.index') }}" class="btn btn-sm btn-outline">Manage</a></div>
            <div class="panel-body">
                @foreach ($materials as $material)
                    @php $stock = $material->stockKg(); $pct = $material->thresholdPercent(); @endphp
                    <div class="pool-row">
                        <div class="top">
                            <strong>{{ $material->name }}</strong>
                            <span>{{ kg($stock) }} / {{ kg($material->bulk_threshold_kg) }}</span>
                        </div>
                        <div @class(['progress', 'full' => $pct >= 100])><span style="width:{{ $pct }}%"></span></div>
                        @if ($pct >= 100)
                            <small style="color:var(--danger);font-weight:700">Bulk threshold reached. Ready to dispatch.</small>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="panel">
            <div class="panel-head"><h2>Wallet liability</h2></div>
            <div class="panel-body">
                <p class="muted" style="font-size:14px">Money households have earned but not yet withdrawn.</p>
                <strong style="font-size:28px">{{ ugx($kpi['wallets']) }}</strong>
                <p class="muted mb-0" style="font-size:14px;margin-top:10px">{{ $kpi['today'] }} new pickup {{ \Illuminate\Support\Str::plural('booking', $kpi['today']) }} today.</p>
            </div>
        </section>
    </div>
</div>
@endsection
