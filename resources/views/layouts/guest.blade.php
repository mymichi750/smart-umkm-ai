<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Smart UMKM POS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="{{ asset('css/ui.css') }}?v={{ filemtime(public_path('css/ui.css')) }}" />
    </head>
    <body {{ $attributes->class(['auth-shell']) }}>
        <div class="auth-card d-grid gap-0 gap-lg-4">
            <div class="auth-hero d-flex flex-column justify-content-between p-5 text-white">
                <div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="brand-mark d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-primary shadow-sm" style="width:64px;height:64px;">
                            <i class="bi bi-basket-fill fs-3"></i>
                        </div>
                    </div>
                    <h1 class="h3 fw-semibold mb-3 text-center text-lg-start">Smart UMKM POS</h1>
                    <p class="mb-4 opacity-75 text-center text-lg-start">Masuk untuk mengelola penjualan, produk, pelanggan, dan laporan bisnis UMKM Anda dengan tampilan yang cepat, bersih, dan modern.</p>
                </div>

                <div class="d-none d-lg-block">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="feature-dot bg-white"></div>
                        <span class="small text-white-75">Tampilan premium untuk UMKM</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="feature-dot bg-white"></div>
                        <span class="small text-white-75">Form login/register yang lebih rapi</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="feature-dot bg-white"></div>
                        <span class="small text-white-75">Responsif dan estetis</span>
                    </div>
                </div>
            </div>

            <div class="auth-form p-4 p-lg-5">
                <div class="mb-4 text-center d-lg-none">
                    <h2 class="h4 fw-bold mb-2">Selamat Datang Kembali</h2>
                    <p class="text-muted mb-0">Masuk untuk melanjutkan ke dashboard bisnis Anda.</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
