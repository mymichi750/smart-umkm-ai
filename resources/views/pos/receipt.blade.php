<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-1">Struk Transaksi</h2>
                <p class="text-muted mb-0">Cetak struk atau simpan sebagai PDF.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Kasir
                </a>
                <button type="button" onclick="window.print()" class="btn btn-outline-primary">
                    <i class="bi bi-printer me-1"></i>Cetak
                </button>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-0">Smart UMKM POS</h5>
                        <p class="mb-0 text-muted">Struk Transaksi</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Invoice:</strong> {{ $transaction->invoice }}</p>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
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
                            <span>Total:</span>
                            <strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Dibayar:</span>
                            <strong>Rp {{ number_format($transaction->paid, 0, ',', '.') }}</strong>
                        </div>
                        <div class="mb-0 d-flex justify-content-between">
                            <span>Kembalian:</span>
                            <strong>Rp {{ number_format($transaction->change, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <p class="text-muted mt-4">Terima kasih telah berbelanja di Smart UMKM POS.</p>
            </div>
        </div>
    </div>
</x-app-layout>
