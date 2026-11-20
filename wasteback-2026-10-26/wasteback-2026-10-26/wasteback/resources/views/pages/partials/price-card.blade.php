@php
    $icons = ['plastic' => 'bottle', 'metal' => 'cog', 'paper' => 'file', 'glass' => 'glass', 'ewaste' => 'cpu'];
@endphp
<article class="price-card">
    <img src="{{ img($material->image ?: 'bottles', 700, 420) }}" alt="{{ $material->name }}" loading="lazy">
    <div class="body">
        <div class="meta">
            <span class="chip"><x-icon :name="$icons[$material->category] ?? 'recycle'" size="14" /> {{ $material->categoryLabel() }}</span>
        </div>
        <h3 style="font-size:20px">{{ $material->name }}</h3>
        <p class="muted" style="font-size:15px;flex:1">{{ $material->description }}</p>
        <div class="price">{{ ugx($material->price_per_kg) }} <small>per kg</small></div>
    </div>
</article>
