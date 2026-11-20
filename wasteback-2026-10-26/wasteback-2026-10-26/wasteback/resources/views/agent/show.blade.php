@extends('layouts.portal', ['title' => 'Pickup '.$pickup->reference])

@section('heading', 'Pickup '.$pickup->reference)
@section('subheading', $pickup->pickup_date->format('l, j M Y').', '.$pickup->slotLabel())

@section('content')
<div class="grid-2">
    <div>
        @if ($pickup->status === 'assigned')
            <form method="POST" action="{{ route('agent.pickups.collect', $pickup) }}" class="panel" data-quote>
                @csrf
                <div class="panel-head"><h2>Enter verified weights</h2><x-status :value="$pickup->status" /></div>
                <div class="panel-body">
                    @foreach ($pickup->items as $item)
                        <div class="item-row">
                            <div class="mat-cell">
                                <img src="{{ img($item->material->image ?: 'bottles', 120, 120) }}" alt="">
                                <div><strong>{{ $item->material->name }}</strong><br><small class="muted">Estimated {{ kg($item->estimated_kg) }}, {{ ugx($item->price_per_kg) }} per kg</small></div>
                            </div>
                            <div>
                                <label class="sr-only" for="w{{ $item->id }}">Verified kilograms of {{ $item->material->name }}</label>
                                <input class="input" type="number" step="0.1" min="0" max="5000" id="w{{ $item->id }}" name="weights[{{ $item->id }}]" value="{{ old('weights.'.$item->id) }}" placeholder="kg" required data-id="{{ $item->id }}" data-price="{{ $item->price_per_kg }}">
                            </div>
                            <strong class="text-right" data-line="{{ $item->id }}">UGX 0</strong>
                        </div>
                    @endforeach
                    <div class="gap-row" style="justify-content:space-between;margin:18px 0;padding:16px;border-radius:14px;background:var(--lime-100)">
                        <span>Payout for <strong data-quote-kg>0 kg</strong></span>
                        <strong style="font-size:22px" data-quote-total>UGX 0</strong>
                    </div>
                    <label class="check" style="margin-bottom:16px"><input type="checkbox" name="confirm" value="1" required> I weighed every material in front of the household.</label>
                    <button class="btn btn-lime btn-block" type="submit"><x-icon name="check" size="16" /> Confirm Collection and Pay</button>
                </div>
            </form>
        @else
            <section class="panel">
                <div class="panel-head"><h2>Materials</h2><x-status :value="$pickup->status" /></div>
                @include('partials.pickup-items')
            </section>
        @endif
    </div>

    <section class="panel">
        <div class="panel-head"><h2>Household</h2></div>
        <div class="panel-body">
            <dl class="dl">
                <dt>Name</dt><dd>{{ $pickup->user->name }}</dd>
                <dt>Phone</dt><dd><a href="tel:{{ $pickup->user->phone }}" class="lime-text">{{ $pickup->user->phone }}</a></dd>
                <dt>Area</dt><dd>{{ $pickup->zone }}</dd>
                <dt>Address</dt><dd>{{ $pickup->address }}</dd>
                @if ($pickup->notes)<dt>Notes</dt><dd>{{ $pickup->notes }}</dd>@endif
            </dl>
            <a href="tel:{{ $pickup->user->phone }}" class="btn btn-dark btn-block" style="margin-top:18px"><x-icon name="phone" size="16" /> Call Household</a>
        </div>
    </section>
</div>
@endsection
