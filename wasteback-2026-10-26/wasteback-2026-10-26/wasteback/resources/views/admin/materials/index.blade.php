@extends('layouts.portal', ['title' => 'Materials and Prices'])

@section('heading', 'Materials and Prices')
@section('subheading', 'Price changes apply to new bookings. Existing bookings keep the price they were quoted.')

@section('content')
<section class="panel">
    <div class="panel-head"><h2>Price list</h2></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Material</th><th>Category</th><th class="text-right">Price per kg</th><th class="text-right">Bulk threshold</th><th class="text-right">In stock</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @foreach ($materials as $material)
                    <tr>
                        <td><div class="mat-cell"><img src="{{ img($material->image ?: 'bottles', 100, 100) }}" alt=""><strong>{{ $material->name }}</strong></div></td>
                        <td>{{ $material->categoryLabel() }}</td>
                        <td class="text-right"><strong>{{ ugx($material->price_per_kg) }}</strong></td>
                        <td class="text-right">{{ kg($material->bulk_threshold_kg) }}</td>
                        <td class="text-right">{{ kg($material->stockKg()) }}</td>
                        <td><x-status :value="$material->is_active ? 'active' : 'inactive'" /></td>
                        <td class="text-right"><a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-outline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<form method="POST" action="{{ route('admin.materials.store') }}" class="panel">
    @csrf
    <div class="panel-head"><h2>Add a material</h2></div>
    @include('admin.materials.fields', ['material' => new \App\Models\Material(['is_active' => true])])
    <div class="panel-body" style="padding-top:0"><button class="btn btn-lime" type="submit"><x-icon name="plus" size="16" /> Add Material</button></div>
</form>
@endsection
