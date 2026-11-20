@extends('layouts.portal', ['title' => 'Inventory Pool'])

@section('heading', 'Inventory Pool')
@section('subheading', 'Verified household collections pooled per material, against the bulk quantity each recycling plant needs.')

@section('content')
<div class="grid-2">
    <section class="panel">
        <div class="panel-head"><h2>Stock against bulk thresholds</h2></div>
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Material</th><th class="text-right">In stock</th><th class="text-right">Threshold</th><th style="width:30%">Progress</th></tr></thead>
                <tbody>
                    @foreach ($materials as $material)
                        @php $pct = $material->thresholdPercent(); @endphp
                        <tr>
                            <td><strong>{{ $material->name }}</strong><br><small class="muted">{{ $material->categoryLabel() }}</small></td>
                            <td class="text-right">{{ kg($material->stockKg()) }}</td>
                            <td class="text-right">{{ kg($material->bulk_threshold_kg) }}</td>
                            <td>
                                <div @class(['progress', 'full' => $pct >= 100])><span style="width:{{ $pct }}%"></span></div>
                                <small @if ($pct >= 100) style="color:var(--danger);font-weight:700" @else class="muted" @endif>{{ $pct >= 100 ? 'Ready to dispatch' : $pct.'%' }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div>
        <form method="POST" action="{{ route('admin.inventory.dispatch') }}" class="panel">
            @csrf
            <div class="panel-head"><h2>Dispatch bulk load</h2></div>
            <div class="panel-body" style="display:grid;gap:14px">
                <div class="field">
                    <label for="material_id">Material</label>
                    <select id="material_id" name="material_id" class="input" required>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" @selected(old('material_id') == $material->id)>{{ $material->name }} ({{ kg($material->stockKg()) }} in stock)</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="recycling_partner_id">Recycling plant</label>
                    <select id="recycling_partner_id" name="recycling_partner_id" class="input" required>
                        @foreach ($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="quantity_kg">Quantity (kg)</label>
                    <input id="quantity_kg" name="quantity_kg" type="number" min="1" step="0.5" class="input" value="{{ old('quantity_kg') }}" required>
                </div>
                <div class="field">
                    <label for="price_per_kg">Price the partner pays (UGX per kg)</label>
                    <input id="price_per_kg" name="price_per_kg" type="number" min="0" step="50" class="input" value="{{ old('price_per_kg') }}" required>
                </div>
                <div class="field">
                    <label for="truck_plate">Truck number plate (optional)</label>
                    <input id="truck_plate" name="truck_plate" class="input" value="{{ old('truck_plate') }}" placeholder="UBK 123A">
                </div>
                <button class="btn btn-lime btn-block" type="submit"><x-icon name="truck" size="16" /> Record Dispatch</button>
            </div>
        </form>
    </div>
</div>

<div class="grid-2">
    <section class="panel">
        <div class="panel-head"><h2>Recent bulk dispatches</h2></div>
        @if ($dispatches->isEmpty())
            <div class="empty"><x-icon name="factory" size="40" /><p class="mb-0">No bulk loads dispatched yet.</p></div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead><tr><th>Reference</th><th>Date</th><th>Material</th><th>Plant</th><th class="text-right">Quantity</th><th class="text-right">Received</th><th>Truck</th></tr></thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                            <tr>
                                <td><strong>{{ $dispatch->reference }}</strong></td>
                                <td>{{ $dispatch->created_at->format('j M Y') }}</td>
                                <td>{{ $dispatch->material->name }}</td>
                                <td>{{ $dispatch->partner->name }}</td>
                                <td class="text-right">{{ kg($dispatch->quantity_kg) }}</td>
                                <td class="text-right"><strong>{{ ugx($dispatch->amount) }}</strong><br><small class="muted">{{ ugx($dispatch->price_per_kg) }}/kg</small></td>
                                <td>{{ $dispatch->truck_plate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <div>
        <section class="panel">
            <div class="panel-head"><h2>Recycling partners</h2><strong>{{ ugx($received) }} received</strong></div>
            <div class="panel-body">
                @foreach ($partners as $partner)
                    <div class="pool-row">
                        <div class="top"><strong>{{ $partner->name }}</strong><span>{{ ugx($partner->dispatches_sum_amount ?? 0) }}</span></div>
                        <small class="muted">{{ kg($partner->dispatches_sum_quantity_kg ?? 0) }} sold. {{ $partner->location }}. Accepts {{ $partner->accepts }}.</small>
                    </div>
                @endforeach
            </div>
        </section>
        <form method="POST" action="{{ route('admin.inventory.partners.store') }}" class="panel">
            @csrf
            <div class="panel-head"><h2>Add partner</h2></div>
            <div class="panel-body" style="display:grid;gap:12px">
                <input name="name" class="input" placeholder="Company name" required aria-label="Company name">
                <input name="location" class="input" placeholder="Location" required aria-label="Location">
                <input name="contact_phone" class="input" placeholder="Phone (optional)" aria-label="Phone">
                <input name="accepts" class="input" placeholder="Materials accepted" required aria-label="Materials accepted">
                <button class="btn btn-dark" type="submit">Add Partner</button>
            </div>
        </form>
    </div>
</div>
@endsection
