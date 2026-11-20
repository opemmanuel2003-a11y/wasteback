@extends('layouts.portal', ['title' => 'Transactions'])

@section('heading', 'Transaction Log')
@section('subheading', 'Every wallet credit and simulated withdrawal on the platform.')

@section('content')
<div class="kpis" style="grid-template-columns:repeat(3,1fr)">
    <div class="kpi"><span class="ico"><x-icon name="coins" size="24" /></span><div><small>Total credited</small><strong>{{ ugx($credits) }}</strong></div></div>
    <div class="kpi"><span class="ico"><x-icon name="send" size="24" /></span><div><small>Total withdrawn</small><strong>{{ ugx($withdrawals) }}</strong></div></div>
    <div class="kpi feature"><span class="ico"><x-icon name="wallet" size="24" /></span><div><small>Held in wallets</small><strong>{{ ugx($credits - $withdrawals) }}</strong></div></div>
</div>

<section class="panel">
    <div class="panel-head">
        <div class="filters">
            <a href="{{ route('admin.transactions.index') }}" @class(['on' => ! $type])>All</a>
            <a href="{{ route('admin.transactions.index', ['type' => 'credit']) }}" @class(['on' => $type === 'credit'])>Credits</a>
            <a href="{{ route('admin.transactions.index', ['type' => 'withdrawal']) }}" @class(['on' => $type === 'withdrawal'])>Withdrawals</a>
        </div>
        <form method="GET" class="inline-form">
            @if ($type)<input type="hidden" name="type" value="{{ $type }}">@endif
            <input name="q" class="input" value="{{ $search }}" placeholder="Reference or name" aria-label="Search transactions">
            <button class="btn btn-sm btn-dark" type="submit">Search</button>
        </form>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Date</th><th>Reference</th><th>User</th><th>Description</th><th>Type</th><th class="text-right">Amount</th><th class="text-right">Balance after</th></tr></thead>
            <tbody>
                @forelse ($transactions as $tx)
                    <tr>
                        <td style="white-space:nowrap">{{ $tx->created_at->format('j M Y, H:i') }}</td>
                        <td><strong>{{ $tx->reference }}</strong></td>
                        <td>{{ $tx->user->name }}</td>
                        <td>{{ $tx->description }}</td>
                        <td><x-status :value="$tx->type" /></td>
                        <td class="text-right" style="white-space:nowrap;font-weight:700">{{ ugx($tx->amount) }}</td>
                        <td class="text-right" style="white-space:nowrap">{{ ugx($tx->balance_after) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-pager :items="$transactions" />
</section>
@endsection
