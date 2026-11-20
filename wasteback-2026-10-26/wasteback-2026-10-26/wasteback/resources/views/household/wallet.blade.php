@extends('layouts.portal', ['title' => 'My Wallet'])

@section('heading', 'My Wallet')
@section('subheading', 'Withdrawals in this project are simulated. No real money moves.')

@section('content')
<div class="grid-2-even" style="margin-bottom:24px">
    <div class="wallet-hero">
        <small>Available balance</small>
        <div class="bal">{{ ugx($user->wallet_balance) }}</div>
        <div class="gap-row" style="gap:30px;margin-top:18px;position:relative;z-index:1">
            <div><small>Total earned</small><br><strong>{{ ugx($earned) }}</strong></div>
            <div><small>Total withdrawn</small><br><strong>{{ ugx($withdrawn) }}</strong></div>
        </div>
    </div>

    <section class="panel mb-0">
        <div class="panel-head"><h2>Withdraw to mobile money</h2></div>
        <form method="POST" action="{{ route('household.wallet.withdraw') }}" class="panel-body form-grid">
            @csrf
            <div class="field">
                <label for="amount">Amount (UGX)</label>
                <input class="input" type="number" id="amount" name="amount" min="{{ \App\Services\Buyback::MIN_WITHDRAWAL }}" max="{{ (int) $user->wallet_balance }}" step="500" value="{{ old('amount') }}" required>
                <div class="hint">Minimum {{ ugx(\App\Services\Buyback::MIN_WITHDRAWAL) }}</div>
            </div>
            <div class="field">
                <label for="channel">Network</label>
                <select class="input" id="channel" name="channel">
                    @foreach (\App\Models\WalletTransaction::CHANNELS as $key => $label)
                        <option value="{{ $key }}" @selected(old('channel') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field full">
                <label for="phone">Mobile number</label>
                <input class="input" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
            </div>
            <div class="full">
                <button class="btn btn-lime" type="submit" @disabled($user->wallet_balance < \App\Services\Buyback::MIN_WITHDRAWAL)>Withdraw <x-icon name="send" size="16" /></button>
            </div>
        </form>
    </section>
</div>

<section class="panel">
    <div class="panel-head"><h2>Transaction history</h2></div>
    @include('household.partials.transactions')
    <x-pager :items="$transactions" />
</section>
@endsection
