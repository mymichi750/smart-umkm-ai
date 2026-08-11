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

                    <div class="small text-white-50 d-none d-sm-block">
                        Point of Sale System
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





            @if(auth()->check())

            <li class="nav-item mb-1">

                <a class="nav-link d-flex flex-column align-items-center justify-content-center px-3 py-3 
                {{ request()->routeIs('ai-assistant.*') ? 'active' : '' }}" 
                href="{{ route('ai-assistant.index') }}"
                aria-label="AI Assistant"
                title="AI Assistant">

                    <img src="{{ asset('images/logo.png') }}"
                         alt=""
                         class="ai-assistant-logo">

                    <span class="ai-assistant-label">AI Asisten</span>

                </a>

            </li>

            @endif






            @if(strtolower(auth()->user()->role ?? '') === 'admin')

            <li class="nav-item mb-1">

                <a class="nav-link d-flex align-items-center px-3 py-3 
                {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                href="{{ route('users.index') }}">

                    <i class="bi bi-person-gear me-3"></i>

                    Pengguna

                </a>

            </li>

            @endif


        </ul>


    </div>

</div>
