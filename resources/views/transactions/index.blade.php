<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Transaksi</h2>
                <p class="text-muted mb-0">Riwayat transaksi kasir.</p>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-8">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari invoice atau pelanggan">
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th></th>
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
                                    <td class="text-end">
                                        <div class="crud-actions" role="group" aria-label="Aksi transaksi">
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-outline-secondary crud-action-btn" title="Lihat detail" aria-label="Lihat detail transaksi"><i class="bi bi-eye"></i></a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger crud-action-btn" title="Hapus" aria-label="Hapus transaksi"><i class="bi bi-trash"></i></button>
                                        </form>
                                        </div>
                                    </td>
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
                $('#transactionsTable').DataTable({
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
