@extends('layouts.site', ['title' => 'Contact Us'])

@section('content')
<x-page-banner title="Contact Us" image="containers" crumb="Contact" />

<section class="section">
    <div class="container contact-grid">
        <div>
            <span class="tag">Get In Touch</span>
            <h2 style="font-size:clamp(28px,3.2vw,40px)">Talk to the WasteBack team</h2>
            <p class="muted">Questions about prices, a pickup in your area, joining as a field agent or supplying a recycling plant. We reply within one working day.</p>
            <div class="info-card"><span class="ico"><x-icon name="map-pin" size="22" /></span><div><small>Office</small><strong>{{ config('site.address') }}</strong></div></div>
            <div class="info-card"><span class="ico"><x-icon name="phone" size="22" /></span><div><small>Call or WhatsApp</small><strong><a href="tel:{{ config('site.phone_link') }}">{{ config('site.phone') }}</a></strong></div></div>
            <div class="info-card"><span class="ico"><x-icon name="mail" size="22" /></span><div><small>Email</small><strong><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></strong></div></div>
            <div class="info-card"><span class="ico"><x-icon name="clock" size="22" /></span><div><small>Working hours</small><strong>{{ config('site.hours') }}</strong></div></div>
        </div>
        <div>
            <x-flash />
            <form method="POST" action="{{ route('contact.send') }}" class="form-card">
                @csrf
                <h3>Send us a message</h3>
                <div class="form-grid" style="margin-top:18px">
                    <div class="field">
                        <label for="name">Your name</label>
                        <input id="name" name="name" class="input" value="{{ old('name') }}" required>
                    </div>
                    <div class="field">
                        <label for="phone">Phone number</label>
                        <input id="phone" name="phone" class="input" value="{{ old('phone') }}" required placeholder="0772123456">
                    </div>
                    <div class="field">
                        <label for="email">Email (optional)</label>
                        <input id="email" name="email" type="email" class="input" value="{{ old('email') }}">
                    </div>
                    <div class="field">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" class="input" required>
                            @foreach (['Pickup in my area', 'Prices and payments', 'Become a field agent', 'Recycling plant partnership', 'Other'] as $subject)
                                <option @selected(old('subject') === $subject)>{{ $subject }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field full">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="input" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="full">
                        <button class="btn btn-lime" type="submit">Send Message <span class="btn-dot"><x-icon name="send" size="14" /></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="container">
    <div class="video-banner" style="background-image:url('{{ img('kampala', 1800, 800) }}');min-height:340px">
        <div class="inner">
            <div>
                <span class="tag tag-dark">Service Areas</span>
                <h2 style="font-size:32px">We collect in {{ implode(', ', array_slice(config('site.zones'), 0, -1)) }} and {{ last(config('site.zones')) }}.</h2>
            </div>
        </div>
    </div>
</section>
@endsection
