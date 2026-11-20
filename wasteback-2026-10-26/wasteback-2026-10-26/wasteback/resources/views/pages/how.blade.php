@extends('layouts.site', ['title' => 'How It Works'])

@section('content')
<x-page-banner title="How It Works" image="truck_dump" />

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">For Households</span>
            <h2>Four steps from sorted scrap to money</h2>
        </div>
        <div class="steps">
            @foreach ([
                ['Register and list', 'Sign up with your phone number and area, then list the materials you have and their rough weights.', 'phone_woman2'],
                ['Book a pickup', 'See the instant quote, choose a date and a time slot, and confirm your address or landmark.', 'phone_hands'],
                ['Agent collects', 'A field agent assigned to your zone arrives, weighs each material and confirms the collection.', 'agent_vest'],
                ['Wallet is credited', 'The verified amount is added to your wallet at once. Withdraw it to mobile money when you like.', 'phone_man'],
            ] as $i => [$heading, $text, $image])
                <div class="step">
                    <div class="pic"><img src="{{ img($image, 300, 300) }}" alt="" loading="lazy"><span class="num">{{ sprintf('%02d', $i + 1) }}</span></div>
                    <h3>{{ $heading }}</h3>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="container">
    <section class="section dark" style="padding-left:40px;padding-right:40px">
        <div class="section-head center">
            <span class="tag tag-dark">Behind The Scenes</span>
            <h2>How data moves through the platform</h2>
            <p>Each step updates the next, so the household, the agent and the administrator always see the same numbers.</p>
        </div>
        <div class="cards-3">
            <div class="v-card"><span class="ico"><x-icon name="list" size="26" /></span><h3>1. Listing and quote</h3><p>The household's listing passes through the pricing engine, which locks in the current price per kilogram for each material.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="send" size="26" /></span><h3>2. Dispatch</h3><p>The administrator assigns the pickup to a field agent, and it appears on that agent's collection list.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="scale" size="26" /></span><h3>3. Verification</h3><p>The agent enters the verified weights. The pickup is marked collected and the payout is calculated.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="wallet" size="26" /></span><h3>4. Wallet ledger</h3><p>The household wallet is credited and a transaction is written to the ledger with the new balance.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="layers" size="26" /></span><h3>5. Inventory pool</h3><p>Verified kilograms join the stock pool for each material and are compared with the bulk threshold.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="factory" size="26" /></span><h3>6. Bulk dispatch</h3><p>When a pool is full the administrator dispatches a truckload to a partner recycling plant.</p></div>
        </div>
    </section>
</div>

<section class="section">
    <div class="container faq-grid">
        <div class="faq">
            <span class="tag">FAQ</span>
            <h2 style="font-size:clamp(28px,3.2vw,42px)">Questions people ask</h2>
            @foreach ($faqs as $i => $faq)
                <details @if ($i === 0) open @endif>
                    <summary>{{ $faq['q'] }} <x-icon name="chevron-down" size="20" /></summary>
                    <p>{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
        <div class="faq-img">
            <img src="{{ img('bin_woman', 800, 1040) }}" alt="A woman dropping waste into a collection bin" loading="lazy">
        </div>
    </div>
</section>
@endsection
