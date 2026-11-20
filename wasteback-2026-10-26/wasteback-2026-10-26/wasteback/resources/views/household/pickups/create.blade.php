@extends('layouts.portal', ['title' => 'Book a Pickup'])

@section('heading', 'Book a Pickup')
@section('subheading', 'Enter rough weights. The agent weighs everything again on site.')

@section('content')
<form method="POST" action="{{ route('household.pickups.store') }}" class="calc" data-quote>
    @csrf
    <div>
        <section class="panel">
            <div class="panel-head"><h2>1. What are you selling?</h2><span class="muted" style="font-size:13px">Leave a material empty if you do not have it</span></div>
            <div class="panel-body">
                @foreach ($materials->groupBy('category') as $category => $group)
                    <h3 style="font-size:15px;margin:{{ $loop->first ? '0' : '20px' }} 0 2px;color:var(--green-700)">{{ \App\Models\Material::CATEGORIES[$category] }}</h3>
                    @foreach ($group as $material)
                        <div class="item-row">
                            <div class="mat-cell">
                                <img src="{{ img($material->image ?: 'bottles', 120, 120) }}" alt="">
                                <div><strong>{{ $material->name }}</strong><br><small class="muted">{{ ugx($material->price_per_kg) }} per kg</small></div>
                            </div>
                            <div>
                                <label class="sr-only" for="item{{ $material->id }}">Kilograms of {{ $material->name }}</label>
                                <input class="input" type="number" min="0" max="5000" step="0.5" id="item{{ $material->id }}" name="items[{{ $material->id }}]" value="{{ old('items.'.$material->id) }}" placeholder="0 kg" data-id="{{ $material->id }}" data-price="{{ $material->price_per_kg }}">
                            </div>
                            <strong class="text-right" data-line="{{ $material->id }}">UGX 0</strong>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </section>

        <section class="panel">
            <div class="panel-head"><h2>2. When and where?</h2></div>
            <div class="panel-body form-grid">
                <div class="field">
                    <label for="pickup_date">Pickup date</label>
                    <input class="input" type="date" id="pickup_date" name="pickup_date" min="{{ today()->toDateString() }}" max="{{ today()->addDays(30)->toDateString() }}" value="{{ old('pickup_date', today()->addDay()->toDateString()) }}" required>
                </div>
                <div class="field">
                    <label for="time_slot">Time slot</label>
                    <select class="input" id="time_slot" name="time_slot" required>
                        @foreach (\App\Models\Pickup::SLOTS as $key => $hours)
                            <option value="{{ $key }}" @selected(old('time_slot') === $key)>{{ ucfirst($key) }} ({{ $hours }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="zone">Area</label>
                    <select class="input" id="zone" name="zone" required>
                        @foreach (config('site.zones') as $zone)
                            <option value="{{ $zone }}" @selected(old('zone', $user->zone) === $zone)>{{ $zone }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="address">Address or landmark</label>
                    <input class="input" id="address" name="address" value="{{ old('address', $user->address) }}" required>
                </div>
                <div class="field full">
                    <label for="notes">Notes for the agent (optional)</label>
                    <textarea class="input" id="notes" name="notes" style="min-height:90px" placeholder="For example: blue gate, call when you reach the stage">{{ old('notes') }}</textarea>
                </div>
            </div>
        </section>
    </div>

    <aside class="calc-total">
        <small style="color:rgba(255,255,255,.7)">Estimated payout</small>
        <div class="big" data-quote-total>UGX 0</div>
        <p style="color:rgba(255,255,255,.7)">for <span data-quote-kg>0 kg</span></p>
        <button type="submit" class="btn btn-lime btn-block">Confirm Booking <x-icon name="check" size="16" /></button>
        <p style="font-size:13px;color:rgba(255,255,255,.6);margin:16px 0 0">Prices are locked when you book. You are paid for the weight the agent measures.</p>
    </aside>
</form>
@endsection
