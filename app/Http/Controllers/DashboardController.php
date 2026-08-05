<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $salesToday = Transaction::whereDate('created_at', $today)->sum('total');
        $transactionsToday = Transaction::whereDate('created_at', $today)->count();
        $productsCount = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock')->limit(5)->get();

        $salesSummary = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date)->format('d M');
                return $item;
            });

        return view('dashboard', compact(
            'salesToday',
            'transactionsToday',
            'productsCount',
            'lowStockProducts',
            'salesSummary'
        ));
    }
}
