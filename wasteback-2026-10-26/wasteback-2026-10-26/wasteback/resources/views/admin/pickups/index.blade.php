@extends('layouts.portal', ['title' => 'Pickups and Dispatch'])

@section('heading', 'Pickups and Dispatch')

@section('content')
<section class="panel">
    <div class="panel-head">
        <div class="filters">
            <a href="{{ route('admin.pickups.index', array_filter(['zone' => $zone, 'q' => $search])) }}" @class(['on' => ! $status])>All</a>
            @foreach (\App\Models\Pickup::STATUSES as $s)
                <a href="{{ route('admin.pickups.index', array_filter(['status' => $s, 'zone' => $zone, 'q' => $search])) }}" @class(['on' => $status === $s])>{{ $s }}</a>
            @endforeach
        </div>
        <form method="GET" class="inline-form">
            @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
            <select name="zone" class="input" style="min-width:140px" aria-label="Filter by area">
                <option value="">All areas</option>
                @foreach (config('site.zones') as $z)
                    <option @selected($zone === $z)>{{ $z }}</option>
                @endforeach
            </select>
            <input name="q" class="input" value="{{ $search }}" placeholder="Reference, name or phone" aria-label="Search">
            <button class="btn btn-sm btn-dark" type="submit">Filter</button>
        </form>
    </div>
    @if ($pickups->isEmpty())
        <div class="empty"><x-icon name="truck" size="40" /><p class="mb-0">No pickups match these filters.</p></div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Reference</th><th>Household</th><th>Area</th><th>Date and slot</th><th class="text-right">Amount</th><th>Status</th><th>Agent</th></tr></thead>
                <tbody>
                    @foreach ($pickups as $pickup)
                        <tr>
                            <td><a href="{{ route('admin.pickups.show', $pickup) }}"><strong>{{ $pickup->reference }}</strong></a></td>
                            <td>{{ $pickup->user->name }}<br><small class="muted">{{ $pickup->user->phone }}</small></td>
                            <td>{{ $pickup->zone }}</td>
                            <td>{{ $pickup->pickup_date->format('j M Y') }}<br><small class="muted">{{ ucfirst($pickup->time_slot) }}</small></td>
                            <td class="text-right" style="white-space:nowrap">{{ ugx($pickup->verified_total ?? $pickup->estimated_total) }}</td>
                            <td><x-status :value="$pickup->status" /></td>
                            <td>
                                @if (in_array($pickup->status, ['pending', 'assigned']))
                                    <form method="POST" action="{{ route('admin.pickups.assign', $pickup) }}" class="inline-form" style="flex-wrap:nowrap">
                                        @csrf @method('PATCH')
                                        <select name="agent_id" class="input" style="min-width:150px;padding:8px 10px" aria-label="Agent for {{ $pickup->reference }}">
                                            @foreach ($agents as $agent)
                                                <option value="{{ $agent->id }}" @selected($pickup->agent_id === $agent->id || (! $pickup->agent_id && $agent->zone === $pickup->zone))>{{ $agent->name }} ({{ $agent->zone }})</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-lime" type="submit">{{ $pickup->agent_id ? 'Reassign' : 'Assign' }}</button>
                                    </form>
                                @else
                                    {{ $pickup->agent?->name ?? 'None' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-pager :items="$pickups" />
    @endif
</section>
@endsection
