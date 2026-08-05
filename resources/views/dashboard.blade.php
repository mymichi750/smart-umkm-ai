<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Dashboard</h2>
                <p class="text-muted mb-0">Ringkasan penjualan dan performa produk UMKM Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')

        <div class="dashboard-header">
            <h1>🚀 Smart UMKM AI Dashboard</h1>
            <p>
                Pantau penjualan, stok produk, dan performa bisnis Anda secara real-time dengan bantuan AI.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
            <div class="col">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div>
                                <span class="d-block text-uppercase text-primary fw-semibold small">Total Penjualan Hari Ini</span>
                                <h3 class="mt-3 mb-0 fw-bold">Rp {{ number_format($salesToday, 0, ',', '.') }}</h3>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-cash-stack fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div>
                                <span class="d-block text-uppercase text-info fw-semibold small">Transaksi Hari Ini</span>
                                <h3 class="mt-3 mb-0 fw-bold">{{ $transactionsToday }}</h3>
                            </div>
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-bag-check-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div>
                                <span class="d-block text-uppercase text-secondary fw-semibold small">Jumlah Produk</span>
                                <h3 class="mt-3 mb-0 fw-bold">{{ $productsCount }}</h3>
                            </div>
                            <div class="icon-box bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-box-seam fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div>
                                <span class="d-block text-uppercase text-warning fw-semibold small">Stok Menipis</span>
                                <h3 class="mt-3 mb-0 fw-bold">{{ $lowStockProducts->count() }}</h3>
                            </div>
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Ringkasan Penjualan 7 Hari</h5>
                            <small class="text-muted">Data penjualan terbaru untuk membantu keputusan cepat.</small>
                        </div>
                        <span class="badge bg-success">Realtime</span>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="320"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom bg-white">
                        <h5 class="mb-0">Produk Stok Menipis</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($lowStockProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom rounded-0">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <div class="text-muted small">SKU: {{ $product->sku ?? '-' }}</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress" style="width:80px;height:8px;">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                 style="width: {{ min(($product->stock / 10) * 100, 100) }}%"
                                                 aria-valuenow="{{ min(($product->stock / 10) * 100, 100) }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill">
                                            {{ $product->stock }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Tidak ada produk dengan stok menipis.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('salesChart');
                if (!ctx) return;

                const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [{!! $salesSummary->pluck('date')->map(fn($item)=>"'{$item}'")->join(', ') !!}],
                        datasets: [{
                            label: 'Penjualan',
                            data: [{!! $salesSummary->pluck('total')->join(', ') !!}],
                            borderColor: '#2563eb',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(15, 23, 42, 0.08)' },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
