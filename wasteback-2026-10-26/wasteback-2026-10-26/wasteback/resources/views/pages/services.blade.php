@extends('layouts.site', ['title' => 'Services'])

@section('content')
<x-page-banner title="Our Services" image="loading" crumb="Services" />

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">What We Do</span>
            <h2>From your compound to the recycling plant</h2>
            <p>Every service is part of one chain: households sell, agents collect, the platform pays and pools, and recyclers receive in bulk.</p>
        </div>
        <div class="cards-3">
            @foreach ([
                ['hand-coins', 'Household Buyback', 'Sell sorted plastics, metal, paper, glass and small electronics at a published price per kilogram.'],
                ['calendar', 'Pickup Scheduling', 'Choose a date and a morning, afternoon or evening slot. Cancel any time before the agent is on the way.'],
                ['scale', 'On-site Weighing', 'Field agents weigh each material with a scale in front of you and record the verified weight.'],
                ['wallet', 'Digital Wallet', 'Payments land in your wallet immediately with a full history of credits and withdrawals.'],
                ['layers', 'Inventory Pooling', 'Verified collections join a central stock pool per material, tracked against plant thresholds.'],
                ['factory', 'Bulk Supply to Recyclers', 'Once a pool reaches its bulk threshold we dispatch a full truck to a partner recycling plant.'],
            ] as [$icon, $heading, $text])
                <div class="v-card">
                    <span class="ico"><x-icon :name="$icon" size="26" /></span>
                    <h3>{{ $heading }}</h3>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="cat-grid" style="margin-top:0">
            @foreach ([
                ['Plastics', 'bottles', 'bottle'],
                ['Metals', 'scrap_metal', 'cog'],
                ['Paper', 'cardboard', 'file'],
                ['Electronic Scrap', 'ewaste', 'cpu'],
            ] as [$label, $image, $icon])
                <a href="{{ route('prices') }}" class="cat-card">
                    <img src="{{ img($image, 600, 540) }}" alt="{{ $label }}" loading="lazy">
                    <span class="label">{{ $label }}</span>
                    <span class="corner"><span><x-icon :name="$icon" size="22" /></span></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container split">
        <div class="split-img">
            <img src="{{ img('agent_vest', 900, 1040) }}" alt="A field worker in a reflective vest on a city street" loading="lazy">
        </div>
        <div>
            <span class="tag">For Recycling Plants</span>
            <h2 style="font-size:clamp(28px,3.2vw,42px)">A steady, documented supply of secondary raw material.</h2>
            <p class="muted">Individual households produce too little for an industrial plant to collect. We aggregate thousands of small collections into graded bulk loads, with weights recorded at every step.</p>
            <ul class="checklist">
                <li><x-icon name="check" size="22" /> Material sorted by grade at the source</li>
                <li><x-icon name="check" size="22" /> Live stock levels per material</li>
                <li><x-icon name="check" size="22" /> Dispatch records with truck and quantity</li>
            </ul>
            <a href="{{ route('contact') }}" class="btn btn-lime">Become A Partner <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a>
        </div>
    </div>
</section>

<section class="container">
    <div class="cta-strip">
        <div>
            <h3>Have scrap at home right now?</h3>
            <p class="mb-0" style="color:rgba(255,255,255,.75)">Check today's prices and book a pickup in under two minutes.</p>
        </div>
        <a href="{{ route('prices') }}" class="btn btn-lime">Check Prices</a>
    </div>
</section>
@endsection
