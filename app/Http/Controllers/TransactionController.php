<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['user', 'customer'])
            ->when($request->q, function ($query, $q) {
                $query->where('invoice', 'like', "%{$q}%")
                    ->orWhereHas('customer', fn($q2) => $q2->where('name', 'like', "%{$q}%"));
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'customer', 'details.product']);

        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('success', 'Riwayat transaksi berhasil dihapus.');
    }
}
