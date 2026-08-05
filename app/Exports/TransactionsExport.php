<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        $transactions = Transaction::with(['user', 'customer'])
            ->whereBetween('created_at', [$this->start, $this->end])
            ->orderByDesc('created_at')
            ->get();

        return view('reports.excel', compact('transactions'));
    }
}
