@extends('layouts.portal', ['title' => 'My Pickups'])

@section('heading', 'My Pickups')

@section('content')
<section class="panel">
    <div class="panel-head">
        <div class="filters">
            <a href="{{ route('household.pickups.index') }}" @class(['on' => ! $status])>All</a>
            @foreach (\App\Models\Pickup::STATUSES as $s)
                <a href="{{ route('household.pickups.index', ['status' => $s]) }}" @class(['on' => $status === $s])>{{ $s }}</a>
            @endforeach
        </div>
        <a href="{{ route('household.pickups.create') }}" class="btn btn-sm btn-lime"><x-icon name="plus" size="16" /> New pickup</a>
    </div>
    @if ($pickups->isEmpty())
        <div class="empty"><x-icon name="truck" size="40" /><p class="mb-0">No pickups found.</p></div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Reference</th><th>Date and slot</th><th>Weight</th><th class="text-right">Amount</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @foreach ($pickups as $pickup)
                        <tr>
                            <td><strong>{{ $pickup->reference }}</strong></td>
                            <td>{{ $pickup->pickup_date->format('j M Y') }}<br><small class="muted">{{ $pickup->slotLabel() }}</small></td>
                            <td>{{ $pickup->status === 'collected' ? kg($pickup->verifiedKg()) : kg($pickup->estimatedKg()).' est.' }}</td>
                            <td class="text-right" style="white-space:nowrap">{{ $pickup->status === 'collected' ? ugx($pickup->verified_total) : ugx($pickup->estimated_total).' est.' }}</td>
                            <td><x-status :value="$pickup->status" /></td>
                            <td class="text-right"><a href="{{ route('household.pickups.show', $pickup) }}" class="btn btn-sm btn-outline">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-pager :items="$pickups" />
    @endif
</section>
@endsection
