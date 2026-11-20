<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body>
@php
    $user = auth()->user();
    $menus = [
        'household' => [
            ['household.dashboard', 'Overview', 'home', 'household.dashboard'],
            ['household.pickups.create', 'Book a Pickup', 'plus', 'household.pickups.create'],
            ['household.pickups.index', 'My Pickups', 'truck', 'household.pickups.index|household.pickups.show'],
            ['household.wallet', 'My Wallet', 'wallet', 'household.wallet'],
        ],
        'agent' => [
            ['agent.dashboard', 'Collection List', 'list', 'agent.dashboard|agent.pickups.*'],
            ['agent.history', 'History', 'clock', 'agent.history'],
        ],
        'admin' => [
            ['admin.dashboard', 'Dashboard', 'chart', 'admin.dashboard'],
            ['admin.pickups.index', 'Pickups', 'truck', 'admin.pickups.*'],
            ['admin.inventory.index', 'Inventory Pool', 'layers', 'admin.inventory.*'],
            ['admin.materials.index', 'Materials and Prices', 'coins', 'admin.materials.*'],
            ['admin.transactions.index', 'Transactions', 'wallet', 'admin.transactions.*'],
            ['admin.users.index', 'Users', 'users', 'admin.users.*'],
            ['admin.messages.index', 'Messages', 'inbox', 'admin.messages.*'],
        ],
    ];
    $counts = [];
    if ($user->isAdmin()) {
        $counts['admin.pickups.index'] = \App\Models\Pickup::where('status', 'pending')->count();
        $counts['admin.messages.index'] = \App\Models\ContactMessage::where('is_read', false)->count();
    } elseif ($user->isAgent()) {
        $counts['agent.dashboard'] = $user->assignedPickups()->where('status', 'assigned')->count();
    }
@endphp
<div class="portal">
    <aside class="sidebar" id="sidebar">
        <x-logo />
        <div class="side-label">{{ ucfirst($user->role) }} menu</div>
        <nav class="side-nav">
            @foreach ($menus[$user->role] as [$route, $label, $icon, $active])
                <a href="{{ route($route) }}" @class(['active' => request()->routeIs(...explode('|', $active))])>
                    <x-icon :name="$icon" size="19" /> {{ $label }}
                    @if (! empty($counts[$route]))<span class="count">{{ $counts[$route] }}</span>@endif
                </a>
            @endforeach
        </nav>
        <div class="side-label">Account</div>
        <nav class="side-nav">
            <a href="{{ route('profile.edit') }}" @class(['active' => request()->routeIs('profile.*')])><x-icon name="settings" size="19" /> Profile</a>
            <a href="{{ route('home') }}"><x-icon name="home" size="19" /> Website</a>
        </nav>
        <div class="side-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><x-icon name="logout" size="19" /> Sign out</button>
            </form>
        </div>
    </aside>

    <div class="portal-main">
        <header class="topbar">
            <div class="gap-row">
                <button class="side-toggle" type="button" data-toggle="sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Open menu"><x-icon name="menu" size="26" /></button>
                <div>
                    <h1>@yield('heading')</h1>
                    <div class="sub">@yield('subheading', now()->format('l, j F Y'))</div>
                </div>
            </div>
            <div class="user-chip">
                <span class="av">{{ $user->initials() }}</span>
                <span><strong style="font-size:14px">{{ $user->name }}</strong><small>{{ $user->role }}{{ $user->zone ? ', '.$user->zone : '' }}</small></span>
            </div>
        </header>
        <div class="portal-body">
            <x-flash />
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/site.js') }}?v=2"></script>
</body>
</html>
