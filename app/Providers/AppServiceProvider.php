<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Seluruh halaman menggunakan Bootstrap 5. Pagination Laravel harus
        // memakai view Bootstrap agar SVG Tailwind tidak merusak layout.
        Paginator::useBootstrapFive();
    }
}
