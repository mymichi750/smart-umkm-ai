<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Smart UMKM AI') }}
    </title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">


    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css">


    {{-- ui.css adalah stylesheet dashboard yang aktif. Parameter versi mencegah
         browser memakai CSS lama setelah layout diperbarui. --}}
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}?v={{ filemtime(public_path('css/ui.css')) }}">


    @stack('styles')


</head>


<body class="dashboard-body">


<div class="app-shell d-flex min-vh-100">


    @include('layouts.navigation')



    <div class="flex-fill app-main">



        <!-- TOP NAVBAR -->

        <nav class="navbar main-navbar px-4 py-3">


            <div class="container-fluid">


                <button 
                class="btn sidebar-toggle d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-label="Buka menu navigasi">

                    <i class="bi bi-list"></i>

                </button>





                <div class="d-flex align-items-center gap-2 gap-sm-3">


                    <div class="brand-title">

                        <span class="d-none d-sm-inline">
                            {{ config('app.name','Smart UMKM AI') }}
                        </span>

                        <span class="d-sm-none">
                            <i class="bi bi-robot me-1"></i>
                            Smart UMKM
                        </span>

                    </div>



                    <span class="ai-badge d-none d-md-inline-flex">

                        <i class="bi bi-robot me-1"></i>

                        AI Dashboard

                    </span>


                </div>





                <!-- USER -->

                <div class="ms-auto d-flex align-items-center gap-3">


                    <div class="d-none d-md-block welcome-text">

                        Selamat datang,
                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                    </div>





                    <div class="dropdown">


                        <a class="profile-button dropdown-toggle"
                           href="#"
                           data-bs-toggle="dropdown">


                            <div class="profile-mini">

                                <i class="bi bi-person-fill"></i>

                            </div>


                            <span class="d-none d-md-inline">

                                {{ auth()->user()->name }}

                            </span>


                        </a>





                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">


                            <li>

                                <a class="dropdown-item py-2"
                                   href="{{ route('profile.edit') }}">

                                    <i class="bi bi-person me-2"></i>

                                    Profile

                                </a>

                            </li>



                            <li>

                                <form method="POST"
                                      action="{{ route('logout') }}">

                                    @csrf


                                    <button class="dropdown-item py-2">

                                        <i class="bi bi-box-arrow-right me-2"></i>

                                        Logout

                                    </button>


                                </form>

                            </li>


                        </ul>


                    </div>


                </div>


            </div>


        </nav>







        <main class="content-wrapper">


            @isset($header)

                <div class="page-heading">

                    {{ $header }}

                </div>

            @endisset



            <div class="dashboard-content">

                {{ $slot }}

            </div>


        </main>



    </div>


</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebarMenu');
        if (!sidebar || !window.bootstrap) return;

        // Pada layar kecil, tutup menu setelah pengguna memilih halaman.
        sidebar.querySelectorAll('a.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.matchMedia('(max-width: 991.98px)').matches) {
                    bootstrap.Offcanvas.getOrCreateInstance(sidebar).hide();
                }
            });
        });
    });
</script>


@stack('scripts')


</body>

</html>
