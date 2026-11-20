@extends('layouts.portal', ['title' => 'My Profile'])

@section('heading', 'My Profile')

@section('content')
<div class="grid-2-even">
    <form method="POST" action="{{ route('profile.update') }}" class="panel">
        @csrf @method('PUT')
        <div class="panel-head"><h2>Personal details</h2></div>
        <div class="panel-body form-grid">
            <div class="field full">
                <label for="name">Full name</label>
                <input id="name" name="name" class="input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="input" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="field">
                <label for="phone">Mobile number</label>
                <input id="phone" name="phone" class="input" value="{{ old('phone', $user->phone) }}" required>
            </div>
            <div class="field">
                <label for="zone">Area</label>
                <select id="zone" name="zone" class="input">
                    @foreach (config('site.zones') as $zone)
                        <option @selected(old('zone', $user->zone) === $zone)>{{ $zone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="address">Address</label>
                <input id="address" name="address" class="input" value="{{ old('address', $user->address) }}">
            </div>
            <div class="full"><button class="btn btn-lime" type="submit">Save Details</button></div>
        </div>
    </form>

    <form method="POST" action="{{ route('profile.password') }}" class="panel">
        @csrf @method('PUT')
        <div class="panel-head"><h2>Change password</h2></div>
        <div class="panel-body" style="display:grid;gap:16px">
            <div class="field">
                <label for="current_password">Current password</label>
                <input id="current_password" name="current_password" type="password" class="input" required autocomplete="current-password">
            </div>
            <div class="field">
                <label for="password">New password</label>
                <input id="password" name="password" type="password" class="input" required autocomplete="new-password">
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="input" required autocomplete="new-password">
            </div>
            <div><button class="btn btn-dark" type="submit">Change Password</button></div>
        </div>
    </form>
</div>
@endsection
