@extends('layouts.portal', ['title' => 'New User'])

@section('heading', 'New User')
@section('subheading', 'Field agents and administrators are created here. Households can also sign up on the website.')

@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="panel" style="max-width:820px">
    @csrf
    <div class="panel-head"><h2>Account details</h2></div>
    <div class="panel-body form-grid">
        <div class="field">
            <label for="name">Full name</label>
            <input id="name" name="name" class="input" value="{{ old('name') }}" required>
        </div>
        <div class="field">
            <label for="role">Role</label>
            <select id="role" name="role" class="input">
                @foreach (['agent' => 'Field agent', 'admin' => 'Administrator', 'household' => 'Household'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', 'agent') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label for="phone">Mobile number</label>
            <input id="phone" name="phone" class="input" value="{{ old('phone') }}" required placeholder="0772123456">
        </div>
        <div class="field">
            <label for="zone">Area</label>
            <select id="zone" name="zone" class="input">
                @foreach (config('site.zones') as $zone)
                    <option @selected(old('zone') === $zone)>{{ $zone }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="address">Address (optional)</label>
            <input id="address" name="address" class="input" value="{{ old('address') }}">
        </div>
        <div class="field full">
            <label for="password">Temporary password</label>
            <input id="password" name="password" type="text" class="input" required autocomplete="new-password">
            <div class="hint">At least 8 characters with letters and numbers. Share it with the user privately.</div>
        </div>
        <div class="full gap-row">
            <button class="btn btn-lime" type="submit">Create Account</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </div>
</form>
@endsection
