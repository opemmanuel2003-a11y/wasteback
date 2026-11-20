@extends('layouts.auth', ['title' => 'Create Account', 'image' => 'market_woman'])

@section('side-title', 'Your scrap has value')
@section('side-text', 'Register your household, list the plastics, metal and paper you have sorted, and get paid for every kilogram our agents collect.')

@section('content')
    <span class="tag">Household Sign Up</span>
    <h1>Create your account</h1>
    <p class="muted">Already registered? <a href="{{ route('login') }}" class="lime-text" style="font-weight:700">Sign in</a></p>

    <x-flash />

    <form method="POST" action="{{ route('register') }}" class="form-card">
        @csrf
        <div class="form-grid">
            <div class="field full">
                <label for="name">Full name</label>
                <input id="name" name="name" class="input" value="{{ old('name') }}" required autocomplete="name">
            </div>
            <div class="field">
                <label for="phone">Mobile number</label>
                <input id="phone" name="phone" class="input" value="{{ old('phone') }}" placeholder="0772123456" required autocomplete="tel">
                <div class="hint">Used for pickups and wallet withdrawals.</div>
            </div>
            <div class="field">
                <label for="email">Email address</label>
                <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="field">
                <label for="zone">Area</label>
                <select id="zone" name="zone" class="input" required>
                    <option value="">Choose your area</option>
                    @foreach (config('site.zones') as $zone)
                        <option value="{{ $zone }}" @selected(old('zone') === $zone)>{{ $zone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="address">Pickup address or landmark</label>
                <input id="address" name="address" class="input" value="{{ old('address') }}" required placeholder="Zone, road, landmark">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="input" required autocomplete="new-password">
                <div class="hint">At least 8 characters with letters and numbers.</div>
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="input" required autocomplete="new-password">
            </div>
            <div class="full">
                <button class="btn btn-lime btn-block" type="submit">Create Account <x-icon name="arrow-right" size="16" /></button>
            </div>
        </div>
    </form>
    <p style="margin-top:20px"><a href="{{ route('home') }}" class="muted">Back to the website</a></p>
@endsection
