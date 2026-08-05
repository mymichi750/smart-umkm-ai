<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Laporan</h2>
                <p class="text-muted mb-0">Lihat dan ekspor laporan penjualan.</p>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start" value="{{ request('start', $start->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end" value="{{ request('end', $end->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('reports.export.pdf') }}" method="POST" class="d-inline-block me-2">
                    @csrf
                    <input type="hidden" name="start" value="{{ request('start', $start->format('Y-m-d')) }}">
                    <input type="hidden" name="end" value="{{ request('end', $end->format('Y-m-d')) }}">
                    <button class="btn btn-outline-danger">Export PDF</button>
                </form>
                <form action="{{ route('reports.export.excel') }}" method="POST" class="d-inline-block">
                    @csrf
                    <input type="hidden" name="start" value="{{ request('start', $start->format('Y-m-d')) }}">
                    <input type="hidden" name="end" value="{{ request('end', $end->format('Y-m-d')) }}">
                    <button class="btn btn-outline-success">Export Excel</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="reportsTable">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->invoice }}</td>
                                    <td>{{ $transaction->customer->name ?? 'Umum' }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#reportsTable').DataTable({
                    paging: false,
                    info: false,
                    searching: false,
                    responsive: true,
                    ordering: true,
                });
            });
        </script>
    @endpush
</x-app-layout>
