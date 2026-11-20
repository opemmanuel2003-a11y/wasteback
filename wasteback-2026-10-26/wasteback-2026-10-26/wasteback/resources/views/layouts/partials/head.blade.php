<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ isset($title) ? $title.' | '.config('site.name') : config('site.name').' | '.config('site.tagline') }}</title>
<meta name="description" content="{{ $description ?? 'WasteBack buys sorted plastics, metal, paper and glass from Kampala households, collects them at the doorstep and pays into a mobile wallet.' }}">
<meta name="theme-color" content="#0a1f14">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='9' fill='%2384c341'/%3E%3Cpath d='M9 12l3 10h8l3-10M8 12h16M13 12V9h6v3' fill='none' stroke='%230a1f14' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/site.css') }}?v=4">
<script>
    // Applied before the body renders, so a dark-mode visitor never sees a white flash.
    (function () {
        try {
            var stored = localStorage.getItem('wasteback-theme');
            var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        } catch (e) {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    })();
</script>
