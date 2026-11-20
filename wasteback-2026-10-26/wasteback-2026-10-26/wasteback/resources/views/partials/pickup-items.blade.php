@php $collected = $pickup->status === 'collected'; @endphp
<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Material</th>
                <th class="text-right">Price per kg</th>
                <th class="text-right">Estimated</th>
                <th class="text-right">Verified</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pickup->items as $item)
                <tr>
                    <td><div class="mat-cell"><img src="{{ img($item->material->image ?: 'bottles', 100, 100) }}" alt=""><strong>{{ $item->material->name }}</strong></div></td>
                    <td class="text-right">{{ ugx($item->price_per_kg) }}</td>
                    <td class="text-right">{{ kg($item->estimated_kg) }}</td>
                    <td class="text-right">{{ $item->verified_kg !== null ? kg($item->verified_kg) : 'Not weighed' }}</td>
                    <td class="text-right" style="font-weight:700">{{ ugx(($collected ? $item->verified_kg : $item->estimated_kg) * $item->price_per_kg) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>{{ $collected ? 'Paid to wallet' : 'Estimated total' }}</strong></td>
                <td class="text-right" style="font-weight:800;font-size:17px">{{ ugx($collected ? $pickup->verified_total : $pickup->estimated_total) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
