@extends('layouts.portal', ['title' => 'Users'])

@section('heading', 'Users')

@section('content')
<section class="panel">
    <div class="panel-head">
        <div class="filters">
            <a href="{{ route('admin.users.index') }}" @class(['on' => ! $role])>All</a>
            @foreach (\App\Models\User::ROLES as $r)
                <a href="{{ route('admin.users.index', ['role' => $r]) }}" @class(['on' => $role === $r])>{{ $r }}s</a>
            @endforeach
        </div>
        <div class="gap-row">
            <form method="GET" class="inline-form">
                @if ($role)<input type="hidden" name="role" value="{{ $role }}">@endif
                <input name="q" class="input" value="{{ $search }}" placeholder="Name, email or phone" aria-label="Search users">
                <button class="btn btn-sm btn-dark" type="submit">Search</button>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-lime"><x-icon name="plus" size="15" /> New user</a>
        </div>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Role</th><th>Contact</th><th>Area</th><th class="text-right">Pickups</th><th class="text-right">Wallet</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td style="text-transform:capitalize">{{ $user->role }}</td>
                        <td>{{ $user->phone }}<br><small class="muted">{{ $user->email }}</small></td>
                        <td>{{ $user->zone }}</td>
                        <td class="text-right">{{ $user->isAgent() ? $user->assigned_pickups_count : $user->pickups_count }}</td>
                        <td class="text-right" style="white-space:nowrap">{{ $user->isHousehold() ? ugx($user->wallet_balance) : '' }}</td>
                        <td><x-status :value="$user->is_active ? 'active' : 'inactive'" /></td>
                        <td class="text-right">
                            @unless ($user->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" data-confirm="{{ $user->is_active ? 'Suspend' : 'Reactivate' }} {{ $user->name }}?">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-outline' }}" type="submit">{{ $user->is_active ? 'Suspend' : 'Reactivate' }}</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-pager :items="$users" />
</section>
@endsection
