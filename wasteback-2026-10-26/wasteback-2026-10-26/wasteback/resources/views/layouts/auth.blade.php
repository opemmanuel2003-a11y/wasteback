<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body>
<div class="auth-wrap">
    <aside class="auth-side" style="background-image:url('{{ img($image ?? 'bottles_bag', 1200) }}')">
        <x-logo />
        <div>
            <h2>@yield('side-title')</h2>
            <p style="color:rgba(255,255,255,.8);max-width:420px">@yield('side-text')</p>
        </div>
    </aside>
    <main class="auth-main">
        <div class="auth-box">
            @yield('content')
        </div>
    </main>
</div>
<script src="{{ asset('js/site.js') }}?v=2"></script>
</body>
</html>
