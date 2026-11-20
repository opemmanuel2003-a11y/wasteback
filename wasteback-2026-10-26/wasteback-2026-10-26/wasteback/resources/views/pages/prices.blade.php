@extends('layouts.site', ['title' => 'Prices'])

@section('content')
<x-page-banner title="Today's Prices" image="bottles_pile" crumb="Prices" />

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Price Calculator</span>
            <h2>How much is your scrap worth?</h2>
            <p>Enter rough weights to see an estimate. The final amount uses the weight our agent measures at pickup.</p>
        </div>

        <form class="calc" data-quote onsubmit="return false">
            <div class="form-card">
                @foreach ($materials->groupBy('category') as $category => $group)
                    <h3 style="font-size:16px;margin:{{ $loop->first ? '0' : '24px' }} 0 4px;color:var(--green-700)">{{ \App\Models\Material::CATEGORIES[$category] }}</h3>
                    @foreach ($group as $material)
                        <div class="calc-row">
                            <div class="mat-cell">
                                <img src="{{ img($material->image ?: 'bottles', 120, 120) }}" alt="" loading="lazy">
                                <div><strong>{{ $material->name }}</strong><br><small class="muted">{{ ugx($material->price_per_kg) }} per kg</small></div>
                            </div>
                            <div>
                                <label class="sr-only" for="m{{ $material->id }}">Kilograms of {{ $material->name }}</label>
                                <input class="input" type="number" min="0" step="0.5" id="m{{ $material->id }}" placeholder="0 kg" data-id="{{ $material->id }}" data-price="{{ $material->price_per_kg }}">
                            </div>
                            <strong class="text-right" data-line="{{ $material->id }}">UGX 0</strong>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <aside class="calc-total">
                <small style="color:rgba(255,255,255,.7)">Estimated payout</small>
                <div class="big" data-quote-total>UGX 0</div>
                <p style="color:rgba(255,255,255,.7)">for <span data-quote-kg>0 kg</span> of sorted material</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-lime btn-block">Go To My Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-lime btn-block">Sign Up And Book Pickup</a>
                @endauth
                <p style="font-size:13px;color:rgba(255,255,255,.6);margin:16px 0 0">Prices can change with the market. The price shown when you book is the price you are paid.</p>
            </aside>
        </form>
    </div>
</section>

<section class="section bg-cream" style="border-radius:36px">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Materials</span>
            <h2>Everything we buy</h2>
        </div>
        <div class="price-grid">
            @foreach ($materials as $material)
                @include('pages.partials.price-card', ['material' => $material])
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Sorting Guide</span>
            <h2>Get the best price for your scrap</h2>
        </div>
        <div class="cards-4">
            <div class="v-card"><span class="ico"><x-icon name="droplet" size="26" /></span><h3>Rinse</h3><p>Rinse bottles and containers so food and drinks do not spoil the batch.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="layers" size="26" /></span><h3>Separate</h3><p>Use one bag per material: plastics, metals, paper and glass apart.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="file" size="26" /></span><h3>Keep paper dry</h3><p>Wet paper and cardboard lose their value. Store them under a roof.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="x" size="26" /></span><h3>No food waste</h3><p>We do not buy food, garden waste, nappies or medical waste.</p></div>
        </div>
    </div>
</section>
@endsection
