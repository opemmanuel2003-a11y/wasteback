<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        return view('admin.materials.index', [
            'materials' => Material::orderBy('category')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(4));
        Material::create($data);

        return back()->with('success', $data['name'].' was added to the price list.');
    }

    public function edit(Material $material): View
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $material->update($this->validated($request) + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.materials.index')
            ->with('success', $material->name.' updated. New bookings use '.ugx($material->price_per_kg).' per kg.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(array_keys(Material::CATEGORIES))],
            'description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:120', 'regex:/^[a-z0-9_-]+$/i'],
            'price_per_kg' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'bulk_threshold_kg' => ['required', 'numeric', 'min:1', 'max:1000000'],
        ], ['image.regex' => 'Use an image key from config/site.php or an Unsplash photo id.']);
    }
}
