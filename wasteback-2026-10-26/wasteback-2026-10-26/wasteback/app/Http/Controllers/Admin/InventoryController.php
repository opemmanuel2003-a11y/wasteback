<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkDispatch;
use App\Models\Material;
use App\Models\RecyclingPartner;
use App\Services\Buyback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        return view('admin.inventory.index', [
            'materials' => Material::orderBy('category')->orderBy('name')->get(),
            'partners' => RecyclingPartner::withSum('dispatches', 'quantity_kg')->withSum('dispatches', 'amount')->orderBy('name')->get(),
            'received' => BulkDispatch::sum('amount'),
            'dispatches' => BulkDispatch::with(['material', 'partner', 'creator'])->latest()->take(15)->get(),
        ]);
    }

    public function dispatch(Request $request, Buyback $buyback): RedirectResponse
    {
        $data = $request->validate([
            'material_id' => ['required', 'exists:materials,id'],
            'recycling_partner_id' => ['required', 'exists:recycling_partners,id'],
            'quantity_kg' => ['required', 'numeric', 'min:1'],
            'price_per_kg' => ['required', 'numeric', 'min:0'],
            'truck_plate' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $dispatch = $buyback->dispatch(Material::findOrFail($data['material_id']), $request->user(), $data);

        return back()->with('success', kg($dispatch->quantity_kg).' of '.$dispatch->material->name.' sold to '.$dispatch->partner->name.' for '.ugx($dispatch->amount).' ('.$dispatch->reference.').');
    }

    public function storePartner(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'accepts' => ['required', 'string', 'max:255'],
        ]);

        RecyclingPartner::create($data);

        return back()->with('success', $data['name'].' was added as a recycling partner.');
    }
}
