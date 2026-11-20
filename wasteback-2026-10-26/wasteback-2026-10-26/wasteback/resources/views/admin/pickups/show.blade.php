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
        @if (in_array($pickup->status, ['pending', 'assigned']))
            <section class="panel">
                <div class="panel-head"><h2>Dispatch to agent</h2></div>
                <form method="POST" action="{{ route('admin.pickups.assign', $pickup) }}" class="panel-body">
                    @csrf @method('PATCH')
                    <div class="field" style="margin-bottom:14px">
                        <label for="agent_id">Field agent</label>
                        <select id="agent_id" name="agent_id" class="input">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" @selected($pickup->agent_id === $agent->id || (! $pickup->agent_id && $agent->zone === $pickup->zone))>{{ $agent->name }} ({{ $agent->zone }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-lime btn-block" type="submit"><x-icon name="send" size="16" /> {{ $pickup->agent_id ? 'Reassign' : 'Dispatch' }}</button>
                </form>
            </section>
        @endif

        <section class="panel">
            <div class="panel-head"><h2>Details</h2></div>
            <div class="panel-body">
                <dl class="dl">
                    <dt>Household</dt><dd>{{ $pickup->user->name }}, {{ $pickup->user->phone }}</dd>
                    <dt>Date</dt><dd>{{ $pickup->pickup_date->format('l, j F Y') }}</dd>
                    <dt>Time slot</dt><dd>{{ $pickup->slotLabel() }}</dd>
                    <dt>Address</dt><dd>{{ $pickup->zone }}: {{ $pickup->address }}</dd>
                    @if ($pickup->notes)<dt>Notes</dt><dd>{{ $pickup->notes }}</dd>@endif
                    <dt>Agent</dt><dd>{{ $pickup->agent?->name ?? 'Not assigned' }}</dd>
                    @if ($pickup->assigned_at)<dt>Dispatched</dt><dd>{{ $pickup->assigned_at->format('j M Y, H:i') }}</dd>@endif
                    @if ($pickup->collected_at)<dt>Collected</dt><dd>{{ $pickup->collected_at->format('j M Y, H:i') }}</dd>@endif
                </dl>
            </div>
        </section>

        @if (in_array($pickup->status, ['pending', 'assigned']))
            <form method="POST" action="{{ route('admin.pickups.cancel', $pickup) }}" data-confirm="Cancel this pickup?">
                @csrf @method('PATCH')
                <button class="btn btn-danger btn-block" type="submit"><x-icon name="x" size="16" /> Cancel Pickup</button>
            </form>
        @endif
        <p style="margin-top:16px"><a href="{{ route('admin.pickups.index') }}" class="muted">Back to all pickups</a></p>
    </div>
</div>
@endsection
