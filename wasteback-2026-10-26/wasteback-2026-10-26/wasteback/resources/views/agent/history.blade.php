@extends('layouts.portal', ['title' => 'Collection History'])

@section('heading', 'Collection History')

@section('content')
<section class="panel">
    @if ($pickups->isEmpty())
        <div class="empty"><x-icon name="clock" size="40" /><p class="mb-0">You have not completed any collections yet.</p></div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Reference</th><th>Collected</th><th>Household</th><th>Area</th><th class="text-right">Weight</th><th class="text-right">Paid</th><th></th></tr></thead>
                <tbody>
                    @foreach ($pickups as $pickup)
                        <tr>
                            <td><strong>{{ $pickup->reference }}</strong></td>
                            <td>{{ $pickup->collected_at->format('j M Y, H:i') }}</td>
                            <td>{{ $pickup->user->name }}</td>
                            <td>{{ $pickup->zone }}</td>
                            <td class="text-right">{{ kg($pickup->verifiedKg()) }}</td>
                            <td class="text-right" style="white-space:nowrap">{{ ugx($pickup->verified_total) }}</td>
                            <td class="text-right"><a href="{{ route('agent.pickups.show', $pickup) }}" class="btn btn-sm btn-outline">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-pager :items="$pickups" />
    @endif
</section>
@endsection
