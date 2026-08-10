<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Smart UMKM POS') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css">

    <style>
        body{
            margin:0;
            padding:0;
            background: linear-gradient(135deg,#f8fafc,#eef2ff,#ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-shell{
            min-height:100vh;
            display:flex;
            align-items:center;
        }

        .welcome-badge{
            display:inline-block;
            padding:10px 20px;
            border-radius:999px;
            background:rgba(79,70,229,.1);
            color:#4f46e5;
            font-weight:600;
        }

        .hero-title{
            font-size:3rem;
            font-weight:800;
            line-height:1.2;
            color:#111827;
        }

        .hero-subtitle{
            font-size:1.15rem;
            color:#6b7280;
        }

        .btn-brand{
            background:#4f46e5;
            color:white;
            border:none;
            padding:12px 28px;
            border-radius:12px;
            font-weight:600;
        }

        .btn-brand:hover{
            background:#4338ca;
            color:white;
        }

        .feature-card{
            background:white;
            border:none;
            border-radius:20px;
            padding:25px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            transition:.3s;
            height:100%;
        }

        .feature-card:hover{
            transform:translateY(-8px);
        }

        .feature-icon{
            width:70px;
            height:70px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            border-radius:20px;
            background:#eef2ff;
            color:#4f46e5;
            font-size:30px;
        }

        .preview-card{
            background:white;
            border-radius:25px;
            padding:30px;
            box-shadow:0 15px 40px rgba(0,0,0,.1);
        }

        .dashboard-preview{
            width:100%;
            border-radius:15px;
        }

        .section-title{
            font-weight:700;
            color:#111827;
        }

        .section-text{
            color:#6b7280;
        }

        @media(max-width:768px){
            .hero-title{
                font-size:2rem;
            }
        }
    </style>
</head>
<body>

<div class="welcome-shell">
    <div class="container py-5">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <div class="welcome-badge mb-4">
                    🚀 Smart UMKM POS
                </div>

                <h1 class="hero-title">
                    Digitalisasi UMKM Menjadi Lebih Mudah dan Profesional
                </h1>

                <p class="hero-subtitle mt-4">
                    Smart UMKM POS membantu pelaku usaha mengelola produk,
                    transaksi, pelanggan, dan operasional bisnis dalam satu
                    platform yang modern, cepat, dan mudah digunakan.
                </p>

                <div class="d-flex flex-wrap gap-3 mt-4">

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-brand">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-brand">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif

                </div>

            </div>

            <div class="col-lg-6">

                <div class="preview-card">

                   <img
    src="{{ asset('images/landing_page.png') }}"
    class="dashboard-preview"
    alt="Smart UMKM POS">

                    <div class="text-center mt-4">
                        <h4 class="section-title">
                            Solusi Modern untuk UMKM Indonesia
                        </h4>

                        <p class="section-text mb-0">
                            Kelola usaha dengan lebih cepat, efisien,
                            dan siap menghadapi era digital.
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-5 g-4">

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <h5 class="mt-3">Kasir Digital</h5>
                    <p class="text-muted mb-0">
                        Proses transaksi lebih cepat dan mudah.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="mt-3">Manajemen Produk</h5>
                    <p class="text-muted mb-0">
                        Kelola produk dan stok dengan rapi.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="mt-3">Pelanggan</h5>
                    <p class="text-muted mb-0">
                        Simpan data pelanggan dalam satu tempat.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="mt-3">Laporan Bisnis</h5>
                    <p class="text-muted mb-0">
                        Pantau perkembangan usaha dengan mudah.
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>