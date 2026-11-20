@extends('layouts.site')

@section('content')
{{-- Hero --}}
<section class="hero">
    <span class="hero-bg" style="background-image:url('{{ img('hero', 1900) }}')" aria-hidden="true"></span>
    <div class="container">
        <div>
            <h1>Turn Your Waste <br><em>Into Cash</em></h1>
            <div class="hero-lead">
                <span class="globe"><x-icon name="recycle" size="24" /></span>
                <p>Sort your plastics, metal, paper and glass at home. We collect them at your door, weigh them in front of you and pay straight into your wallet.</p>
            </div>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-lime">Start Selling Scrap <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a>
                <a href="{{ route('prices') }}" class="btn btn-light">See Today's Prices</a>
            </div>
        </div>
        <a href="{{ route('how') }}" class="hero-card">
            <img src="{{ img('hero_card', 600, 360) }}" alt="A large sack filled with collected plastic bottles">
            <span class="row">Doorstep pickup across Banda and Kampala <span class="play"><x-icon name="arrow-right" size="18" /></span></span>
        </a>
    </div>
</section>

{{-- Category cards --}}
<section>
    <div class="container">
        <div class="cat-grid">
            @foreach ([
                ['Plastic Bottles', 'bottles_pile', 'bottle'],
                ['Metal Scrap', 'scrap_metal', 'cog'],
                ['Paper and Cardboard', 'paper_bales', 'file'],
                ['Doorstep Pickup', 'loading', 'truck'],
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

{{-- About --}}
<section class="section">
    <div class="container about-grid">
        <div class="collage">
            <img class="tall" src="{{ img('bottles_bag', 600, 940) }}" alt="Collected plastic bottles ready for weighing" loading="lazy">
            <div class="stack">
                <img src="{{ img('truck_dump', 700, 510) }}" alt="A truck offloading waste at a sorting facility" loading="lazy">
                <img src="{{ img('dump_walker', 700, 510) }}" alt="A woman carrying a load across an open dumping ground" loading="lazy">
            </div>
            <div class="badge-ring">
                <svg class="ring-text" viewBox="0 0 100 100" aria-hidden="true">
                    <defs><path id="circle" d="M50,50 m-38,0 a38,38 0 1,1 76,0 a38,38 0 1,1 -76,0"/></defs>
                    <text font-size="9" font-weight="700" fill="#ffffff"><textPath href="#circle" textLength="236" lengthAdjust="spacing">ZONES COVERED &#8226; KAMPALA &#8226; BANDA &#8226;</textPath></text>
                </svg>
                <strong>{{ count(config('site.zones')) }}</strong>
            </div>
        </div>
        <div>
            <span class="tag">About Us</span>
            <h2>Turning household scrap into income and cleaner drainage for Kampala.</h2>
            <p class="muted">In Banda and similar settlements, private garbage collection is too expensive for many families, so plastics and scrap end up in drainage channels that flood every rainy season. WasteBack pays households for sorted recyclables, sends a field agent to collect them and moves the material in bulk to recycling plants.</p>
            <div class="feature-box">
                <span class="ico"><x-icon name="scale" size="28" /></span>
                <strong>Weighed in front of you and paid by the kilogram</strong>
            </div>
            <div class="cta-row">
                <a href="{{ route('about') }}" class="btn btn-lime">About More <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a>
                <a href="tel:{{ config('site.phone_link') }}" class="help-line">
                    <span class="ico"><x-icon name="phone" size="20" /></span>
                    <span><small>Need help?</small><strong>{{ config('site.phone') }}</strong></span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services (dark) --}}
<div class="container">
    <section class="section dark" style="padding-left:40px;padding-right:40px">
        <div class="section-head center">
            <span class="tag tag-dark">Services</span>
            <h2>Efficient waste buyback services</h2>
            <p>One platform connects the household, the field agent and the recycling plant.</p>
        </div>
        <div class="svc-wrap">
            <div class="svc-col">
                <div class="svc"><span class="ico"><x-icon name="hand-coins" size="28" /></span><div><h3>Household Buyback</h3><p>List your sorted scrap online and get an instant price quote before anyone comes to your door.</p></div></div>
                <div class="svc"><span class="ico"><x-icon name="truck" size="28" /></span><div><h3>Doorstep Pickup</h3><p>Pick a date and a time slot. A trained field agent comes with a scale and collects the material.</p></div></div>
            </div>
            <div class="svc-center"><img src="{{ img('bottles_cage', 700, 700) }}" alt="Plastic bottles packed in a collection cage" loading="lazy"></div>
            <div class="svc-col right">
                <div class="svc"><span class="ico"><x-icon name="wallet" size="28" /></span><div><h3>Wallet Payouts</h3><p>Verified weights are paid into your digital wallet, ready to withdraw to mobile money.</p></div></div>
                <div class="svc"><span class="ico"><x-icon name="factory" size="28" /></span><div><h3>Bulk Supply</h3><p>Small collections are pooled until they reach the bulk quantities recycling plants need.</p></div></div>
            </div>
        </div>
        <div class="svc-strip">
            <strong>Ready to clear your compound and get paid for it?</strong>
            <a href="{{ route('services') }}" class="btn btn-lime">View All Services <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a>
        </div>
    </section>
</div>

{{-- Safe handling + live stats --}}
<section class="section">
    <div class="container split">
        <div>
            <span class="tag">Why Sort At Home</span>
            <h2 style="font-size:clamp(28px,3.2vw,42px)">Ensuring safe handling and a fair price for every kilogram.</h2>
            <p class="muted">Sorting at the source keeps recyclables clean, which makes them worth more and keeps them out of the channels that block during heavy rain.</p>
            <ul class="checklist">
                <li><x-icon name="check" size="22" /> Clear prices per kilogram, published for everyone</li>
                <li><x-icon name="check" size="22" /> Agents verify every weight on site with a scale</li>
                <li><x-icon name="check" size="22" /> Every payment is recorded in your wallet history</li>
                <li><x-icon name="check" size="22" /> Less plastic in Banda drainage channels and fewer floods</li>
            </ul>
            <div class="stats">
                <div class="stat"><strong>{{ number_format($stats['kg']) }} kg</strong><small>Recyclables collected</small></div>
                <div class="stat"><strong>{{ number_format($stats['households']) }}</strong><small>Households selling</small></div>
                <div class="stat"><strong>{{ ugx($stats['paid']) }}</strong><small>Paid to households</small></div>
            </div>
        </div>
        <div class="split-img">
            <img src="{{ img('drain', 900, 1040) }}" alt="A polluted drainage channel running through a market area" loading="lazy">
            <div class="float-stat">
                <span class="ico"><x-icon name="users" size="24" /></span>
                <div><strong>{{ $stats['agents'] }}</strong><small>Active field agents</small></div>
            </div>
        </div>
    </div>
</section>

{{-- Gallery --}}
<section class="section bg-cream" style="border-radius:36px">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Our Process</span>
            <h2>Transforming waste into a cleaner future</h2>
        </div>
        <div class="gallery-tabs"><span class="on">All</span><span>Plastics</span><span>Metals</span><span>Paper</span><span>Logistics</span></div>
        <div class="gallery">
            <figure><img src="{{ img('containers', 800, 660) }}" alt="Sorted plastic containers stacked outside a building" loading="lazy"><figcaption><strong>Sorted at the source</strong><small>Plastics</small></figcaption></figure>
            <figure><img src="{{ img('loading', 500, 660) }}" alt="Workers loading sacks of recyclables onto a vehicle" loading="lazy"><figcaption><strong>Doorstep collection</strong><small>Logistics</small></figcaption></figure>
            <figure><img src="{{ img('metal_parts', 500, 660) }}" alt="A pile of scrap metal parts" loading="lazy"><figcaption><strong>Metal recovery</strong><small>Metals</small></figcaption></figure>
            <figure><img src="{{ img('cardboard', 500, 660) }}" alt="Flattened cardboard ready for baling" loading="lazy"><figcaption><strong>Paper baling</strong><small>Paper</small></figcaption></figure>
        </div>
    </div>
</section>

{{-- Steps --}}
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Work Process</span>
            <h2>Simple steps to sell your waste</h2>
        </div>
        <div class="steps">
            @foreach ([
                ['List your scrap', 'Create an account and enter the materials and rough weights you have.', 'bottles'],
                ['Get a price', 'The system shows an instant quote based on the current price per kilogram.', 'phone_woman'],
                ['Agent weighs it', 'A field agent arrives at your chosen time, weighs each material and confirms it.', 'agent_vest'],
                ['Get paid', 'Money lands in your wallet immediately and can be withdrawn to mobile money.', 'phone_man'],
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

{{-- Banner --}}
<section class="container">
    <div class="video-banner" style="background-image:url('{{ img('channel', 1800, 900) }}')">
        <div class="inner">
            <div>
                <span class="tag tag-dark">Our Goal</span>
                <h2>Every bottle we buy is one less bottle blocking a Banda drainage channel.</h2>
                <a href="{{ route('register') }}" class="btn btn-lime">Join As A Household <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a>
            </div>
            <a href="{{ route('how') }}" class="play-big" aria-label="See how it works"><x-icon name="play" size="34" /></a>
        </div>
    </div>
</section>

{{-- Team --}}
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Our Team</span>
            <h2>Meet-THE HEROES-team</h2>
            <p>The students behind the design and development of WasteBack.</p>
        </div>
        <div class="team-grid">
            @foreach (config('site.team') as $member)
                <div class="member">
                    <div class="avatar">{{ collect(explode(' ', $member['name']))->take(2)->map(fn ($p) => $p[0])->implode('') }}</div>
                    <h3>{{ $member['name'] }}</h3>
                    <small>{{ $member['role'] }}</small>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="section bg-cream" style="border-radius:36px">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Testimonials</span>
            <h2>What households and agents say</h2>
        </div>
        <div class="testi-grid">
            @foreach ([
                ['I used to burn the bottles behind the house. Now I keep them in a sack and the agent pays me every two weeks.', 'Household seller', 'NALUWAGA', 'market_woman'],
                ['The price is on my phone before the agent comes, so there is no arguing at the gate. The scale decides.', 'Household seller', 'NAMPALA IVY', 'phone_woman2'],
                ['My pickups for the day are on my phone with the address and time. I weigh, confirm and the customer is paid.', 'Field agent', 'OPIO EMMANUEL', 'vendor'],
            ] as [$quote, $role, $place, $image])
                <div class="testi">
                    <span class="q"><x-icon name="quote" size="20" /></span>
                    <div class="stars">@for ($s = 0; $s < 5; $s++)<x-icon name="star" size="16" />@endfor</div>
                    <p>{{ $quote }}</p>
                    <div class="who">
                        <img src="{{ img($image, 120, 120) }}" alt="" loading="lazy">
                        <div><strong>{{ $role }}</strong><small>{{ $place }}</small></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="section">
    <div class="container faq-grid">
        <div class="faq">
            <span class="tag">FAQ</span>
            <h2 style="font-size:clamp(28px,3.2vw,42px)">Frequently asked questions</h2>
            @foreach ($faqs as $i => $faq)
                <details @if ($i === 0) open @endif>
                    <summary>{{ $faq['q'] }} <x-icon name="chevron-down" size="20" /></summary>
                    <p>{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
        <div class="faq-img">
            <img src="{{ img('litter_pick', 800, 1040) }}" alt="A young woman picking up plastic litter into a yellow bag" loading="lazy">
        </div>
    </div>
</section>

{{-- CTA strip --}}
<section class="container">
    <div class="cta-strip">
        <div>
            <h3>Book your first pickup today</h3>
            <p class="mb-0" style="color:rgba(255,255,255,.75)">Free to join. No collection fees. You only need a phone.</p>
        </div>
        <div class="gap-row">
            <a href="{{ route('register') }}" class="btn btn-lime">Create Account</a>
            <a href="tel:{{ config('site.phone_link') }}" class="btn btn-light"><x-icon name="phone" size="16" /> {{ config('site.phone') }}</a>
        </div>
    </div>
</section>

{{-- Prices --}}
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Today's Prices</span>
            <h2>Top paying materials this week</h2>
        </div>
        <div class="price-grid">
            @foreach ($materials as $material)
                @include('pages.partials.price-card', ['material' => $material])
            @endforeach
        </div>
        <p style="text-align:center;margin-top:34px"><a href="{{ route('prices') }}" class="btn btn-dark">View Full Price List <span class="btn-dot"><x-icon name="arrow-up-right" size="15" /></span></a></p>
    </div>
</section>
@endsection
