@if ($transactions->isEmpty())
    <div class="empty"><x-icon name="wallet" size="40" /><p class="mb-0">No wallet transactions yet.</p></div>
@else
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Date</th><th>Description</th><th>Type</th><th class="text-right">Amount</th><th class="text-right">Balance</th></tr></thead>
            <tbody>
                @foreach ($transactions as $tx)
                    <tr>
                        <td style="white-space:nowrap">{{ $tx->created_at->format('j M Y') }}<br><small class="muted">{{ $tx->reference }}</small></td>
                        <td>{{ $tx->description }}</td>
                        <td><x-status :value="$tx->type" /></td>
                        <td class="text-right" style="white-space:nowrap;font-weight:700;color:{{ $tx->type === 'credit' ? 'var(--green-700)' : 'var(--danger)' }}">{{ $tx->type === 'credit' ? '+' : '-' }} {{ ugx($tx->amount) }}</td>
                        <td class="text-right" style="white-space:nowrap">{{ ugx($tx->balance_after) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
