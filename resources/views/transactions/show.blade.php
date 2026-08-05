<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Detail Transaksi</h2>
                <p class="text-muted mb-0">Informasi rinci transaksi.</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Invoice:</strong> {{ $transaction->invoice }}</p>
                        <p class="mb-1"><strong>Pelanggan:</strong> {{ $transaction->customer->name ?? 'Umum' }}</p>
                        <p class="mb-0"><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Total:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                        <p class="mb-1"><strong>Dibayar:</strong> Rp {{ number_format($transaction->paid, 0, ',', '.') }}</p>
                        <p class="mb-0"><strong>Kembalian:</strong> Rp {{ number_format($transaction->change, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td class="text-end">{{ $detail->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row text-end">
                    <div class="col-md-6 offset-md-6">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="fw-semibold">Jumlah Item:</span>
                            <span>{{ $transaction->items_count }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="fw-semibold">Total:</span>
                            <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="fw-semibold">Dibayar:</span>
                            <span>Rp {{ number_format($transaction->paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Kembalian:</span>
                            <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($transaction->notes)
                    <div class="mt-4">
                        <h6>Catatan</h6>
                        <p>{{ $transaction->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
