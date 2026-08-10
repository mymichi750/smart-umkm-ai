<?php

use App\Http\Controllers\AIAssistantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/ai-assistant', [AIAssistantController::class, 'index'])->name('ai-assistant.index');
    Route::post('/admin/ai-assistant/send', [AIAssistantController::class, 'send'])->name('ai-assistant.send');

    Route::middleware(['kasir'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('customers', CustomerController::class);

        Route::get('pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('pos/cart', [PosController::class, 'addToCart'])->name('pos.cart.add');
        Route::patch('pos/cart/{product}', [PosController::class, 'updateCart'])->name('pos.cart.update');
        Route::delete('pos/cart/{product}', [PosController::class, 'removeCart'])->name('pos.cart.remove');
        Route::post('pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('pos/receipt/{transaction}', [PosController::class, 'receipt'])->name('pos.receipt');

        Route::resource('transactions', TransactionController::class)->only(['index', 'show', 'destroy']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::post('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
