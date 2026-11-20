<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\Buyback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('household.wallet', [
            'user' => $user,
            'transactions' => $user->transactions()->with('pickup')->latest()->latest('id')->paginate(15),
            'earned' => (float) $user->transactions()->where('type', 'credit')->sum('amount'),
            'withdrawn' => (float) $user->transactions()->where('type', 'withdrawal')->sum('amount'),
        ]);
    }

    public function withdraw(Request $request, Buyback $buyback): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:'.Buyback::MIN_WITHDRAWAL],
            'channel' => ['required', Rule::in(array_keys(WalletTransaction::CHANNELS))],
            'phone' => ['required', 'string', 'regex:/^(\+256|0)7\d{8}$/'],
        ], ['phone.regex' => 'Enter a Ugandan mobile number such as 0772123456.']);

        $tx = $buyback->withdraw($request->user(), (float) $data['amount'], $data['channel'], $data['phone']);

        return back()->with('success', ugx($tx->amount).' sent to '.WalletTransaction::CHANNELS[$tx->channel].' '.$tx->phone.'. Reference '.$tx->reference.' (simulated).');
    }
}
