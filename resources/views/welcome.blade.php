<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Smart UMKM POS') }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="/css/ui.css" />
    </head>
    <body class="bg-light">
        <div class="welcome-shell min-vh-100 d-flex align-items-center">
            <div class="container py-5">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6">
                        <div class="welcome-badge mb-4">Smart UMKM POS</div>
                        <h1 class="display-6 fw-bold">Kelola penjualan UMKM dengan cepat, rapi, dan profesional.</h1>
                        <p class="lead text-muted mt-3">Dashboard, kasir, produk, pelanggan, dan laporan semua terintegrasi di satu aplikasi yang mudah digunakan.</p>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-brand btn-lg">Buka Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-brand btn-lg">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Daftar Sekarang</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="welcome-card p-4 p-lg-5 shadow-sm rounded-4 bg-white border border-200">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h3 class="h5 mb-1">Ringkasan Hari Ini</h3>
                                    <p class="text-muted mb-0">Lihat performa bisnis dan stok paling penting.</p>
                                </div>
                                <div class="badge bg-success bg-opacity-10 text-success">Versi 1.0</div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card p-3">
                                        <div class="small text-muted">Penjualan</div>
                                        <div class="h4 mb-0">Rp 12.540.000</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card p-3">
                                        <div class="small text-muted">Transaksi</div>
                                        <div class="h4 mb-0">84</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card p-3">
                                        <div class="small text-muted">Produk</div>
                                        <div class="h4 mb-0">128</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card p-3">
                                        <div class="small text-muted">Stok Menipis</div>
                                        <div class="h4 mb-0">6</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
