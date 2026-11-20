@extends('layouts.auth', ['title' => 'Sign In', 'image' => 'bottles_bag'])

@section('side-title', 'Welcome back')
@section('side-text', 'Households track their pickups and wallet, agents see their collection list, and administrators run the whole buyback network from one place.')

@section('content')
    <span class="tag">Sign In</span>
    <h1>Sign in to your account</h1>
    <p class="muted">New here? <a href="{{ route('register') }}" class="lime-text" style="font-weight:700">Create a household account</a></p>

    <x-flash />

    <form method="POST" action="{{ route('login') }}" class="form-card" style="display:grid;gap:18px">
        @csrf
        <div class="field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" class="input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="input" required autocomplete="current-password">
        </div>
        <label class="check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
        <button class="btn btn-lime btn-block" type="submit">Sign In <x-icon name="arrow-right" size="16" /></button>
    </form>

    @if (app()->environment('local'))
        <div class="demo-logins">
            <strong>Demo accounts</strong> (password <code>password</code>)
            <div style="margin-top:8px;display:grid;gap:4px">
                <span>Household: <code>household@wasteback.ug</code></span>
                <span>Field agent: <code>agent@wasteback.ug</code></span>
                <span>Administrator: <code>admin@wasteback.ug</code></span>
            </div>
        </div>
    @endif

    <p style="margin-top:20px"><a href="{{ route('home') }}" class="muted">Back to the website</a></p>
@endsection
