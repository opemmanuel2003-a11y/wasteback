<div class="panel-body form-grid">
    <div class="field">
        <label for="name">Name</label>
        <input id="name" name="name" class="input" value="{{ old('name', $material->name) }}" required>
    </div>
    <div class="field">
        <label for="category">Category</label>
        <select id="category" name="category" class="input">
            @foreach (\App\Models\Material::CATEGORIES as $key => $label)
                <option value="{{ $key }}" @selected(old('category', $material->category) === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="price_per_kg">Price per kg (UGX)</label>
        <input id="price_per_kg" name="price_per_kg" type="number" min="1" step="1" class="input" value="{{ old('price_per_kg', $material->price_per_kg ? (int) $material->price_per_kg : '') }}" required>
    </div>
    <div class="field">
        <label for="bulk_threshold_kg">Bulk threshold (kg)</label>
        <input id="bulk_threshold_kg" name="bulk_threshold_kg" type="number" min="1" step="1" class="input" value="{{ old('bulk_threshold_kg', $material->bulk_threshold_kg ? (int) $material->bulk_threshold_kg : '') }}" required>
        <div class="hint">Stock level at which a truckload goes to a recycling plant.</div>
    </div>
    <div class="field full">
        <label for="description">Description</label>
        <input id="description" name="description" class="input" value="{{ old('description', $material->description) }}">
    </div>
    <div class="field full">
        <label for="image">Image key</label>
        <input id="image" name="image" class="input" value="{{ old('image', $material->image) }}" placeholder="bottles">
        <div class="hint">A key from config/site.php (for example bottles, scrap_metal, cardboard) or an Unsplash photo id.</div>
    </div>
</div>
