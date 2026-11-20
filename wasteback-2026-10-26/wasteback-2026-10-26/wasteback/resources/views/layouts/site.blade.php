<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body>
@php
    $links = [
        'home' => 'Home',
        'about' => 'About',
        'services' => 'Services',
        'prices' => 'Prices',
        'how' => 'How It Works',
        'contact' => 'Contact',
    ];
@endphp
<header class="site-header">
    <div class="container">
        <x-logo />
        <nav class="nav" id="main-nav" aria-label="Main">
            @foreach ($links as $route => $label)
                <a href="{{ route($route) }}" @class(['active' => request()->routeIs($route)])>{{ $label }}</a>
            @endforeach
            @auth
                <a href="{{ route('dashboard') }}">My Dashboard</a>
            @else
                <a href="{{ route('login') }}">Sign In</a>
            @endauth
        </nav>
        <div class="header-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="header-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="header-link">Sign In</a>
            @endauth
            <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode" aria-pressed="false">
                <span class="icon-moon"><x-icon name="moon" size="18" /></span>
                <span class="icon-sun"><x-icon name="sun" size="18" /></span>
            </button>
            <a href="tel:{{ config('site.phone_link') }}" class="call-pill">
                <span class="ring"><x-icon name="phone" size="18" /></span>
                <span><small>Make a call</small><strong>{{ config('site.phone') }}</strong></span>
            </a>
            <button class="nav-toggle" type="button" data-toggle="main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Open menu">
                <x-icon name="menu" size="28" />
            </button>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <x-logo />
                <p style="margin-top:18px">A digital waste buyback and reverse logistics platform. Households in Kampala sell sorted scrap, our agents collect it, and recyclers receive it in bulk.</p>
                <div class="socials">
                    <a href="#" aria-label="Facebook"><x-icon name="facebook" size="17" /></a>
                    <a href="#" aria-label="Instagram"><x-icon name="instagram" size="17" /></a>
                    <a href="#" aria-label="LinkedIn"><x-icon name="linkedin" size="17" /></a>
                    <a href="https://wa.me/{{ config('site.whatsapp') }}" aria-label="WhatsApp"><x-icon name="whatsapp" size="17" /></a>
                </div>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    @foreach ($links as $route => $label)
                        <li><a href="{{ route($route) }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>We Buy</h4>
                <ul>
                    <li><a href="{{ route('prices') }}">Plastic bottles</a></li>
                    <li><a href="{{ route('prices') }}">Metal scrap</a></li>
                    <li><a href="{{ route('prices') }}">Paper and cardboard</a></li>
                    <li><a href="{{ route('prices') }}">Glass bottles</a></li>
                    <li><a href="{{ route('prices') }}">Electronic scrap</a></li>
                </ul>
            </div>
            <div>
                <h4>Get In Touch</h4>
                <ul class="footer-contact">
                    <li><x-icon name="map-pin" size="18" /> {{ config('site.address') }}</li>
                    <li><x-icon name="phone" size="18" /> <a href="tel:{{ config('site.phone_link') }}">{{ config('site.phone') }}</a></li>
                    <li><x-icon name="mail" size="18" /> <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
                    <li><x-icon name="clock" size="18" /> {{ config('site.hours') }}</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} {{ config('site.name') }}. THE HEROES BBC GROUP ITPD project.</span>
            <span>Wallet payouts on this platform are simulated.</span>
        </div>
    </div>
</footer>
<script src="{{ asset('js/site.js') }}?v=2"></script>
</body>
</html>
