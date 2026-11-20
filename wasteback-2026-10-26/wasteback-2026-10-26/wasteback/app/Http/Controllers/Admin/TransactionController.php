<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');
        $search = trim((string) $request->query('q'));

        $query = WalletTransaction::with('user')
            ->when(in_array($type, ['credit', 'withdrawal'], true), fn ($q) => $q->where('type', $type))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('reference', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))));

        return view('admin.transactions.index', [
            'transactions' => (clone $query)->latest()->latest('id')->paginate(20)->withQueryString(),
            'credits' => (float) WalletTransaction::where('type', 'credit')->sum('amount'),
            'withdrawals' => (float) WalletTransaction::where('type', 'withdrawal')->sum('amount'),
            'type' => $type,
            'search' => $search,
        ]);
    }
}
