@extends('layouts.portal', ['title' => 'Pickup '.$pickup->reference])

@section('heading', 'Pickup '.$pickup->reference)
@section('subheading', 'Booked '.$pickup->created_at->format('j M Y, H:i'))

@section('content')
<div class="grid-2">
    <section class="panel">
        <div class="panel-head"><h2>Materials</h2><x-status :value="$pickup->status" /></div>
        @include('partials.pickup-items')
    </section>

    <div>
        <section class="panel">
            <div class="panel-head"><h2>Pickup details</h2></div>
            <div class="panel-body">
                <dl class="dl">
                    <dt>Date</dt><dd>{{ $pickup->pickup_date->format('l, j F Y') }}</dd>
                    <dt>Time slot</dt><dd>{{ $pickup->slotLabel() }}</dd>
                    <dt>Area</dt><dd>{{ $pickup->zone }}</dd>
                    <dt>Address</dt><dd>{{ $pickup->address }}</dd>
                    @if ($pickup->notes)<dt>Notes</dt><dd>{{ $pickup->notes }}</dd>@endif
                    <dt>Field agent</dt><dd>{{ $pickup->agent ? $pickup->agent->name.', '.$pickup->agent->phone : 'Not yet assigned' }}</dd>
                    @if ($pickup->collected_at)<dt>Collected</dt><dd>{{ $pickup->collected_at->format('j M Y, H:i') }}</dd>@endif
                </dl>
            </div>
        </section>
        @if (in_array($pickup->status, ['pending', 'assigned']))
            <form method="POST" action="{{ route('household.pickups.cancel', $pickup) }}" data-confirm="Cancel this pickup?">
                @csrf @method('PATCH')
                <button class="btn btn-danger btn-block" type="submit"><x-icon name="x" size="16" /> Cancel Pickup</button>
            </form>
        @endif
        <p style="margin-top:16px"><a href="{{ route('household.pickups.index') }}" class="muted">Back to my pickups</a></p>
    </div>
</div>
@endsection
