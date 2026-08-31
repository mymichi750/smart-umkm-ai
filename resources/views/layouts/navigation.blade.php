<style>
.modern-sidebar {

    width:280px;
    min-height:100vh;

    background:
    linear-gradient(
        180deg,
        #0f172a,
        #1d4ed8
    );

}

.modern-sidebar .offcanvas-body {
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,.35) transparent;
}

.modern-sidebar .offcanvas-body::-webkit-scrollbar {
    width: 6px;
}

.modern-sidebar .offcanvas-body::-webkit-scrollbar-track {
    background: transparent;
}

.modern-sidebar .offcanvas-body::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.28);
    border-radius: 999px;
}

.modern-sidebar .offcanvas-body::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,.5);
}


.brand-mark {

    width:52px;
    height:52px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:16px;

    background:
    linear-gradient(
        135deg,
        #38bdf8,
        #2563eb
    );

    color:white;

    font-size:25px;

    box-shadow:
    0 12px 25px rgba(0,0,0,.25);

}

.sidebar-brand-name {
    white-space: nowrap;
    line-height: 1.2;
}



.sidebar-user {

    padding:15px;

    border-radius:18px;

    background:
    rgba(255,255,255,.1);

}



.user-avatar {

    width:45px;
    height:45px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#38bdf8;

    color:white;

    font-weight:bold;

}



.user-role {

    font-size:12px;

    padding:4px 10px;

    border-radius:20px;

    background:
    rgba(255,255,255,.15);

    color:white;

}

.premium-trigger {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: 0;
    padding: .3rem .55rem;
    border: 1px solid rgba(250, 204, 21, .55);
    border-radius: 999px;
    background: rgba(250, 204, 21, .14);
    color: #fef08a;
    font-size: .72rem;
    font-weight: 700;
    line-height: 1;
}

.premium-trigger:hover { background: rgba(250, 204, 21, .26); color: #fff; }
.user-role + .premium-trigger { margin-left: .45rem; }
.premium-plan { 
    height: 100%; 
    border: 1px solid var(--bs-border-color); 
    border-radius: 16px; 
    padding: 1.1rem; 
    background-color: var(--bs-body-bg);
    transition: transform 0.2s, box-shadow 0.2s;
}
.premium-plan--featured { 
    border: 2px solid #3b82f6; 
    background-color: rgba(59, 130, 246, 0.05); 
    transform: scale(1.02);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.15);
}
.premium-plan__price { 
    color: var(--bs-heading-color); 
    font-size: 1.35rem; 
    font-weight: 800; 
}
.premium-plan__feature { 
    display: flex; gap: .45rem; margin: .55rem 0; 
    color: var(--bs-body-color); 
    font-size: .86rem; 
    opacity: 0.85;
}
.premium-plan__feature i { 
    color: #22c55e; 
}
.premium-plan__feature i.text-danger { 
    color: #ef4444 !important; 
}
.premium-plan__trial { 
    margin: .85rem 0; padding: .7rem .75rem; 
    border: 1px solid rgba(59, 130, 246, 0.3); 
    border-radius: .75rem; 
    background: rgba(59, 130, 246, 0.1); 
    color: var(--bs-primary); 
    font-size: .8rem; line-height: 1.45; 
}
[data-bs-theme="dark"] .premium-plan {
    background-color: #1e293b;
    border-color: #334155;
}
[data-bs-theme="dark"] .premium-plan--featured {
    background-color: rgba(59, 130, 246, 0.15);
    border-color: #3b82f6;
}
[data-bs-theme="dark"] .premium-plan__trial {
    color: #93c5fd;
}



.sidebar-nav .nav-link {


    color:#dbeafe;

    border-radius:14px;

    transition:.25s;

    font-weight:500;

}



.sidebar-nav .nav-link:hover {


    background:
    rgba(255,255,255,.12);

    color:white;

    transform:translateX(5px);

}



.sidebar-nav .nav-link.active {


    background:
    linear-gradient(
        135deg,
        #2563eb,
        #06b6d4
    );


    color:white;


    box-shadow:
    0 10px 25px rgba(0,0,0,.25);

}

.ai-assistant-logo {
    width: 64px;
    height: 64px;
    flex: 0 0 64px;

    border: 2px solid rgba(255,255,255,.7);
    border-radius: 50%;

    object-fit: cover;

    box-shadow: 0 4px 12px rgba(6,182,212,.4);
}

.ai-assistant-label {
    margin-top: 8px;
    font-size: 13px;
    font-weight: 600;
}

.sidebar-nav .nav-link:hover .ai-assistant-logo {
    transform: rotate(-8deg) scale(1.06);
}



.logout-btn {

    border-radius:14px;

    color:white;

    background:
    rgba(255,255,255,.12);

    border:none;

}



.logout-btn:hover {

    background:#ef4444;

    color:white;

}

/* Aturan ini diletakkan bersama komponen sidebar agar tidak dikalahkan
   oleh style lama ketika layout dibuka pada perangkat kecil. */
@media (max-width: 991.98px) {
    .offcanvas.offcanvas-start.app-sidebar.modern-sidebar {
        --bs-offcanvas-width: min(88vw, 20rem);
        position: fixed !important;
        top: 0;
        left: 0;
        width: min(88vw, 20rem);
        max-width: min(88vw, 20rem);
        min-height: 100dvh;
        height: 100dvh;
        margin: 0;
        overflow: hidden;
    }

    .modern-sidebar .offcanvas-body {
        display: flex;
        flex: 1 1 auto;
        height: auto !important;
        min-height: 0;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-y: contain;
        padding-bottom: max(1rem, env(safe-area-inset-bottom));
    }
}

@media (max-width: 575.98px) {
    .modern-sidebar .offcanvas-header {
        padding: .9rem 1rem;
    }

    .modern-sidebar .sidebar-brand {
        margin: 0 .75rem 1rem !important;
        padding: 0 0 1rem !important;
    }

    .modern-sidebar .sidebar-user {
        margin: 0 .75rem 1rem !important;
        padding: .75rem !important;
    }

    .modern-sidebar .sidebar-nav {
        margin: 0 .75rem 1rem !important;
        padding: 0 !important;
    }

    .modern-sidebar .sidebar-brand-name {
        font-size: 1rem !important;
    }

    .modern-sidebar .brand-mark {
        width: 42px;
        height: 42px;
        border-radius: 13px;
        font-size: 1.2rem;
        flex: 0 0 42px;
    }

    .modern-sidebar .sidebar-nav .nav-link {
        min-height: 48px;
        margin-bottom: .35rem;
        padding: .7rem .85rem !important;
    }

    .modern-sidebar .ai-assistant-logo {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
    }
}
</style>
<div class="offcanvas offcanvas-lg offcanvas-start sidebar app-sidebar modern-sidebar" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">

    <div class="offcanvas-header d-lg-none">
        <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">
            SMART UMKM AI
        </h5>

        <button type="button" 
                class="btn-close btn-close-white" 
                data-bs-dismiss="offcanvas" 
                data-bs-target="#sidebarMenu"
                aria-label="Close">
        </button>
    </div>


    <div class="offcanvas-body px-0 pt-0 pt-lg-4 d-flex flex-column">


        <!-- BRAND -->
        <div class="sidebar-brand px-4 pb-4 mb-3 border-bottom border-white-15">

            <a href="{{ route('dashboard') }}" 
               class="d-flex align-items-center gap-3 text-white text-decoration-none">

                <div class="brand-mark">
                    <i class="bi bi-robot"></i>
                </div>


<div>
                    <div class="sidebar-brand-name fw-bold fs-5">
                        SMART UMKM AI
                    </div>

                    <div class="small text-warning fw-bold mt-1">
                        <i class="bi bi-shop me-1"></i> {{ auth()->user()->store->name ?? 'Point of Sale' }}
                    </div>
                </div>

            </a>

        </div>




        <!-- USER -->
        <div class="sidebar-user mx-4 mb-4">

            <div class="d-flex align-items-center gap-3">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>


                <div>

                    <div class="small text-white-50">
                        Selamat datang
                    </div>

                    <h6 class="text-white mb-1">
                        {{ auth()->user()->name }}
                    </h6>


                    <span class="user-role">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>

    <button type="button" class="premium-trigger" data-bs-toggle="modal" data-bs-target="#premiumModal">
                        <i class="bi bi-stars"></i> 
                        @if(auth()->user()->premium_pending_level)
                            Premium {{ auth()->user()->premium_level ?? 1 }} <span class="opacity-75">(pending)</span>
                        @else
                            Premium {{ auth()->user()->premium_level ?? 1 }}
                        @endif
                    </button>

                </div>

            </div>

        </div>




        <!-- MENU -->
        <ul class="nav nav-pills flex-column px-4 mb-4 flex-grow-1 sidebar-nav">


            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                href="{{ route('dashboard') }}">

                    <i class="bi bi-speedometer2 me-3"></i>

                    Dashboard

                </a>

            </li>




            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('pos.*') ? 'active' : '' }}" 
                href="{{ route('pos.index') }}">

                    <i class="bi bi-basket-fill me-3"></i>

                    Kasir

                </a>

            </li>





            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                href="{{ route('products.index') }}">

                    <i class="bi bi-box-seam me-3"></i>

                    Produk

                </a>

            </li>





            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('categories.*') ? 'active' : '' }}" 
                href="{{ route('categories.index') }}">

                    <i class="bi bi-tags-fill me-3"></i>

                    Kategori

                </a>

            </li>





            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('customers.*') ? 'active' : '' }}" 
                href="{{ route('customers.index') }}">

                    <i class="bi bi-people-fill me-3"></i>

                    Pelanggan

                </a>

            </li>





            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
                href="{{ route('transactions.index') }}">

                    <i class="bi bi-receipt-cutoff me-3"></i>

                    Transaksi

                </a>

            </li>





            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                href="{{ route('reports.index') }}">
                    <i class="bi bi-bar-chart-line-fill me-3"></i>
                    Laporan
                </a>
            </li>

            @if(auth()->user() && auth()->user()->role === 'admin')
            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear me-3"></i>
                    Pengguna
                </a>
            </li>
            @endif

            <li class="nav-item mb-1">
                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('qr-kasir.*') ? 'active' : '' }}" 
                href="{{ route('qr-kasir.index') }}">
                    <i class="bi bi-qr-code-scan me-3"></i>
                    QR Kasir
                </a>
            </li>

            @if(auth()->check())
            <li class="nav-item mb-1">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center px-3 py-3 
                {{ request()->routeIs('ai-assistant.*') ? 'active' : '' }}" 
                href="{{ route('ai-assistant.index') }}"
                aria-label="AI Assistant"
                title="AI Assistant">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="ai-assistant-logo">
                    <span class="ai-assistant-label">AI Asisten</span>
                </a>
            </li>
            @endif
        </ul>


    </div>

</div>

<div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="premiumModalLabel"><i class="bi bi-stars text-warning me-2"></i>Pilih Paket Premium</h5>
                    <p class="text-muted small mb-0">Sesuaikan fitur Smart UMKM AI dengan kebutuhan warung Anda.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                @if(auth()->user()->premium_pending_level)
                <div class="alert alert-info d-flex align-items-start gap-2 mb-3 py-2" role="alert">
                    <i class="bi bi-hourglass-split flex-shrink-0 mt-1"></i>
                    <div class="small">
                        <strong>Pengajuan Premium {{ auth()->user()->premium_pending_level }} sedang diverifikasi.</strong><br>
                        Bukti pembayaran Anda sudah diterima. Admin akan mengaktifkan paket dalam 1×24 jam.
                    </div>
                </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-4">
                        <section class="premium-plan">
                            <span class="badge text-bg-secondary">Paket saat ini</span>
                            <h6 class="fw-bold mt-3 mb-1">Premium 1</h6>
                            <div class="premium-plan__price">Gratis</div>
                            <div class="text-muted small">Selamanya</div>
                            <div class="premium-plan__trial">
                                <i class="bi bi-gift-fill me-1"></i>
                                @if(auth()->user()->isOnTrial())
                                    <strong>Trial aktif:</strong> AI gratis hingga {{ auth()->user()->trial_ends_at->locale('id')->translatedFormat('d M Y') }}.
                                @else
                                    <strong>Bonus pengguna baru:</strong> akses AI gratis selama 1 bulan pertama setelah daftar.
                                @endif
                            </div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>Gunakan fitur website kasir</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>Produk, stok, pelanggan, dan laporan</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-x-circle-fill text-danger"></i><span>Fitur AI belum tersedia</span></div>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="premium-plan premium-plan--featured">
                            <span class="badge text-bg-primary">Populer</span>
                            <h6 class="fw-bold mt-3 mb-1">Premium 2</h6>
                            <div class="premium-plan__price">Rp49.000</div>
                            <div class="text-muted small">per bulan</div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>Semua fitur website kasir</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>AI analisis usaha dan penjualan</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-x-circle-fill text-danger"></i><span>Fitur AI lanjutan belum tersedia</span></div>
                            @if((auth()->user()->premium_level ?? 1) >= 2)
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" disabled>Paket Aktif</button>
                            @elseif(auth()->user()->premium_pending_level == 2)
                                <button type="button" class="btn btn-outline-warning btn-sm w-100 mt-2" disabled><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</button>
                            @elseif(auth()->user()->premium_pending_level)
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" disabled>Ada Pengajuan Aktif</button>
                            @else
                                <button type="button" class="btn btn-primary btn-sm w-100 mt-2" data-premium-level="2" data-premium-name="Premium 2" data-premium-price="Rp49.000/bulan" data-bs-toggle="modal" data-bs-target="#premiumPaymentModal">Beli Sekarang</button>
                            @endif
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="premium-plan">
                            <h6 class="fw-bold mt-3 mb-1">Premium 3</h6>
                            <div class="premium-plan__price">Rp99.000</div>
                            <div class="text-muted small">per bulan</div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>Semua fitur website kasir</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>AI analisis usaha dan penjualan</span></div>
                            <div class="premium-plan__feature"><i class="bi bi-check-circle-fill"></i><span>Akses semua fitur AI</span></div>
                            @if((auth()->user()->premium_level ?? 1) >= 3)
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" disabled>Paket Aktif</button>
                            @elseif(auth()->user()->premium_pending_level == 3)
                                <button type="button" class="btn btn-outline-warning btn-sm w-100 mt-2" disabled><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</button>
                            @elseif(auth()->user()->premium_pending_level)
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2" disabled>Ada Pengajuan Aktif</button>
                            @else
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2" data-premium-level="3" data-premium-name="Premium 3" data-premium-price="Rp99.000/bulan" data-bs-toggle="modal" data-bs-target="#premiumPaymentModal">Beli Sekarang</button>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="premiumPaymentModal" tabindex="-1" aria-labelledby="premiumPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold" id="premiumPaymentModalLabel">Bayar dengan QRIS</h5>
                    <p class="small text-muted mb-0">Scan kode QR untuk mengaktifkan paket premium.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="rounded-3 border p-3 mb-3" style="background: var(--bs-tertiary-bg);">
                    <div class="fw-bold" id="premiumPaymentName">Premium</div>
                    <div class="text-primary fw-bold fs-5" id="premiumPaymentPrice"></div>
                </div>
                @php($storeQris = auth()->user()->store->qris_image ?? null)
                @if($storeQris)
                    <img src="{{ asset('storage/' . $storeQris) }}" alt="QRIS pembayaran paket premium" class="img-fluid border rounded-3 p-2" style="width: min(100%, 250px);">
                @else
                    <div class="rounded-3 border p-4 mb-2 text-center" style="background: var(--bs-tertiary-bg); width: min(100%, 250px); margin: 0 auto;">
                        <i class="bi bi-qr-code fs-1 text-muted"></i>
                        <p class="small text-muted mt-2 mb-0">QRIS belum diatur.<br>Silakan atur di <a href="{{ route('profile.edit') }}">Profil &rarr; Pembayaran</a>.</p>
                    </div>
                @endif
                <p class="small text-muted mt-3 mb-0">Setelah pembayaran berhasil, unggah bukti di bawah.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <form action="{{ route('premium.confirm-payment') }}" method="POST" enctype="multipart/form-data" class="w-100 no-loader" id="premiumPaymentForm">
                    @csrf
                    <input type="hidden" name="premium_level" id="premiumPaymentLevel">
                    <div class="mb-3 text-start">
                        <label for="payment_proof" class="form-label fw-semibold small">
                            <i class="bi bi-paperclip me-1"></i>Bukti Pembayaran <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               class="form-control form-control-sm @error('payment_proof') is-invalid @enderror"
                               id="payment_proof"
                               name="payment_proof"
                               accept=".jpg,.jpeg,.png,.pdf"
                               required>
                        <div class="form-text">Format: JPG, PNG, atau PDF. Maks. 5 MB.</div>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-1"></i>Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('[data-premium-level]').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('premiumPaymentLevel').value = this.dataset.premiumLevel;
            document.getElementById('premiumPaymentName').textContent = this.dataset.premiumName;
            document.getElementById('premiumPaymentPrice').textContent = this.dataset.premiumPrice;
        });
    });
</script>
@endpush
