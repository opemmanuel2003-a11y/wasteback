<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'logo']) }} aria-label="{{ config('site.name') }} home">
    <span class="logo-mark"><x-icon name="trash" size="22" /></span>
    <span>Waste<em>Back</em></span>
</a>
