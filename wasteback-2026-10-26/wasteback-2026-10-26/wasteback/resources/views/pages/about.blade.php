@extends('layouts.site', ['title' => 'About Us'])

@section('content')
<x-page-banner title="About Us" image="kampala" />

<section class="section">
    <div class="container about-grid">
        <div class="collage">
            <img class="tall" src="{{ img('dump', 600, 940) }}" alt="Plastic waste spread across an open dumping ground" loading="lazy">
            <div class="stack">
                <img src="{{ img('dump_walker', 700, 510) }}" alt="A woman walking across a dumping ground" loading="lazy">
                <img src="{{ img('channel', 700, 510) }}" alt="A channel blocked with plastic waste" loading="lazy">
            </div>
        </div>
        <div>
            <span class="tag">Background</span>
            <h2>Kampala's waste problem is a drainage problem.</h2>
            <p class="muted">Kampala is growing faster than its waste services. Less than ten percent of the waste produced in many sub-Saharan cities is recycled in a structured way, and in dense settlements such as Banda the high cost of private garbage collection pushes families to dump plastics and scrap into open spaces and drainage channels.</p>
            <p class="muted">During heavy rain those channels choke with bottles and packaging and overflow, causing flash floods and health risks. Informal waste pickers exist, but their work is fragmented, undocumented and disconnected from the households producing the waste.</p>
            <div class="feature-box">
                <span class="ico"><x-icon name="droplet" size="28" /></span>
                <strong>Fewer bottles in the channels means fewer floods in Banda</strong>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <section class="section dark" style="padding-left:40px;padding-right:40px">
        <div class="section-head center">
            <span class="tag tag-dark">Our Solution</span>
            <h2>A digital buyback and reverse logistics platform</h2>
            <p>Inspired by waste fintech platforms such as Pakam and Cycle-X in Nigeria, WasteBack treats household scrap as a commodity and pays for it.</p>
        </div>
        <div class="cards-3">
            <div class="v-card"><span class="ico"><x-icon name="smartphone" size="26" /></span><h3>For Households</h3><p>List sorted materials, see an instant price, book a doorstep pickup and track the money in a digital wallet.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="scale" size="26" /></span><h3>For Field Agents</h3><p>Receive dispatch lists, weigh materials on site and confirm collections from a phone.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="chart" size="26" /></span><h3>For Administrators</h3><p>Manage users and prices, dispatch agents, review every transaction and track bulk stock against plant thresholds.</p></div>
        </div>
    </section>
</div>

<section class="section">
    <div class="container split">
        <div>
            <span class="tag">Project Goals</span>
            <h2 style="font-size:clamp(28px,3.2vw,42px)">What we set out to achieve</h2>
            <ol class="num-list" style="margin-top:24px">
                <li><span>Help households build the habit of sorting by treating plastics, metal and paper as a valuable commodity rather than a burden.</span></li>
                <li><span>Create an incentive economy where residents of low-income areas like Banda earn direct value from materials that would otherwise be thrown away.</span></li>
                <li><span>Reduce the plastics and solid waste dumped into open spaces and drainage channels, and with it the flash flooding.</span></li>
                <li><span>Build a reliable, transparent supply chain from household micro-collections to bulk industrial recycling plants.</span></li>
                <li><span>Formalise fragmented scrap collection with one data-driven platform for administrators, collectors and recycling partners.</span></li>
            </ol>
        </div>
        <div class="split-img">
            <img src="{{ img('litter_pick', 900, 1040) }}" alt="A young woman collecting litter into a bag" loading="lazy">
            <div class="float-stat">
                <span class="ico"><x-icon name="recycle" size="24" /></span>
                <div><strong>{{ number_format($stats['kg']) }} kg</strong><small>Collected so far</small></div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-cream" style="border-radius:36px">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Scope</span>
            <h2>What the platform covers</h2>
        </div>
        <div class="cards-4">
            <div class="v-card"><span class="ico"><x-icon name="users" size="26" /></span><h3>Three user roles</h3><p>Households and sellers, field collection agents and system administrators.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="coins" size="26" /></span><h3>Listing and pricing</h3><p>Material types and quantities produce an instant quote from the current price tiers.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="calendar" size="26" /></span><h3>Scheduling and dispatch</h3><p>Households book pickups and administrators dispatch them to agents by zone.</p></div>
            <div class="v-card"><span class="ico"><x-icon name="layers" size="26" /></span><h3>Wallet and inventory</h3><p>A simulated wallet ledger for payouts and a B2B inventory pool with bulk thresholds.</p></div>
        </div>
        <div class="alert alert-info" style="margin-top:30px">
            <x-icon name="alert" size="20" />
            <span>Out of scope: physical recycling (melting plastic, refining metal) and live MTN MoMo or Airtel Money billing. Withdrawals are recorded in a simulated transaction log.</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Our Team</span>
            <h2>HEROES BBC GROUP</h2>
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
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="tag">Our Partners</span>
            <h2>Who buys the waste we collect</h2>
        </div>
        <div class="team-grid">
            @foreach (\App\Models\RecyclingPartner::orderBy('name')->get() as $partner)
                <div class="member">
                    <div class="avatar"><x-icon name="factory" size="26" /></div>
                    <h3>{{ $partner->name }}</h3>
                    <small>{{ $partner->accepts }}</small>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
