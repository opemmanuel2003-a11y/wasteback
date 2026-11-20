@props(['title', 'image' => 'dump', 'crumb' => null])
<section class="page-banner" style="background-image:url('{{ img($image, 1800) }}')">
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a>
            <x-icon name="arrow-right" size="16" />
            <span>{{ $crumb ?? $title }}</span>
        </div>
    </div>
</section>
