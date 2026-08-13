<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCashFlowRequest;
use App\Models\CashFlow;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start ? Carbon::parse($request->start)->startOfDay() : Carbon::now()->subMonth()->startOfDay();
        $end = $request->end ? Carbon::parse($request->end)->endOfDay() : Carbon::now()->endOfDay();

        $transactions = Transaction::with(['user', 'customer'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();
        $cashFlows = CashFlow::with(['user', 'product'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $sales = (float) $transactions->sum('total');
        $capital = (float) $cashFlows->where('type', CashFlow::CAPITAL)->sum('amount');
        $expenses = (float) $cashFlows->whereIn('type', [CashFlow::EXPENSE, CashFlow::STOCK_PURCHASE])->sum('amount');
        $openingBalance = $this->cashBalanceBefore($start);

        $history = $this->history($transactions, $cashFlows);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $entries = new LengthAwarePaginator(
            $history->forPage($page, $perPage)->values(),
            $history->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('reports.index', compact('entries', 'start', 'end', 'sales', 'capital', 'expenses', 'openingBalance'));
    }

    public function storeCashFlow(StoreCashFlowRequest $request)
    {
        CashFlow::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('reports.index')->with('success', 'Mutasi kas berhasil dicatat.');
    }

    public function exportPdf(Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();
        $transactions = Transaction::with(['user', 'customer'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact('transactions', 'start', 'end'));

        return $pdf->download('laporan-penjualan-'.$start->format('Ymd').'-'.$end->format('Ymd').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        return Excel::download(new TransactionsExport($start, $end), 'laporan-penjualan-'.$start->format('Ymd').'-'.$end->format('Ymd').'.xlsx');
    }

    private function cashBalanceBefore(Carbon $start): float
    {
        $sales = (float) Transaction::where('created_at', '<', $start)->sum('total');
        $capital = (float) CashFlow::where('created_at', '<', $start)->where('type', CashFlow::CAPITAL)->sum('amount');
        $expenses = (float) CashFlow::where('created_at', '<', $start)
            ->whereIn('type', [CashFlow::EXPENSE, CashFlow::STOCK_PURCHASE])
            ->sum('amount');

        return $sales + $capital - $expenses;
    }

    private function history(Collection $transactions, Collection $cashFlows): Collection
    {
        $sales = $transactions->map(fn (Transaction $transaction) => (object) [
            'date' => $transaction->created_at,
            'description' => "Penjualan {$transaction->invoice}",
            'user' => $transaction->user->name,
            'type' => 'Penjualan Kasir',
            'category' => 'sale',
            'in' => (float) $transaction->total,
            'out' => 0,
        ]);

        $cash = $cashFlows->map(fn (CashFlow $flow) => (object) [
            'date' => $flow->created_at,
            'description' => $flow->description,
            'user' => $flow->user->name,
            'type' => match ($flow->type) {
                CashFlow::CAPITAL => 'Tambah Dana',
                CashFlow::STOCK_PURCHASE => 'Pembelian Stok Produk',
                default => 'Pengeluaran',
            },
            'category' => match ($flow->type) {
                CashFlow::CAPITAL => 'capital',
                CashFlow::STOCK_PURCHASE => 'stock',
                default => 'expense',
            },
            'in' => $flow->type === CashFlow::CAPITAL ? (float) $flow->amount : 0,
            'out' => $flow->type === CashFlow::CAPITAL ? 0 : (float) $flow->amount,
        ]);

        return $sales->concat($cash)->sortByDesc('date')->values();
    }
}
