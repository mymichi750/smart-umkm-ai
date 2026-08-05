<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
            ->paginate(15)
            ->withQueryString();

        return view('reports.index', compact('transactions', 'start', 'end'));
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
}
