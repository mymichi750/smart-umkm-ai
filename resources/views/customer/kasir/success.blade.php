@extends('layouts.customer')

@section('content')
<div class="container-fluid px-3 pt-4 pb-5">
    
    <div class="text-center mb-4">
        @if($transaction->status == 'completed')
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-check-lg fs-1"></i>
            </div>
            <h2 class="fw-bold text-success">LUNAS!</h2>
            <p class="text-muted">Pesanan Anda telah selesai diproses.</p>
        
        @elseif($transaction->status == 'pending_approval')
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-hourglass-split fs-1"></i>
            </div>
            <h2 class="fw-bold">Menunggu Persetujuan</h2>
            <p class="text-muted">Pemilik toko sedang meninjau pesanan Anda.</p>
        
        @elseif($transaction->status == 'awaiting_payment')
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-wallet2 fs-1"></i>
            </div>
            <h2 class="fw-bold">Menunggu Pembayaran</h2>
            <p class="text-muted">Silakan lakukan pembayaran untuk pesanan ini.</p>
            
        @elseif($transaction->status == 'payment_review')
            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-search fs-1"></i>
            </div>
            <h2 class="fw-bold">Menunggu Konfirmasi</h2>
            <p class="text-muted">Pemilik sedang memverifikasi pembayaran Anda.</p>
            
        @elseif($transaction->status == 'pending')
            <div class="bg-warning bg-opacity-10 text-dark rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-shop fs-1"></i>
            </div>
            <h2 class="fw-bold">Pesanan Diterima</h2>
            <p class="text-muted">Silakan bayar di kasir sesuai jumlah tertera.</p>
            
        @elseif($transaction->status == 'rejected')
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-x-lg fs-1"></i>
            </div>
            <h2 class="fw-bold text-danger">Pesanan Ditolak</h2>
            <p class="text-muted">Mohon maaf, pesanan Anda tidak dapat diproses.</p>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm w-100 mx-auto" style="max-width: 450px;">
        <div class="card-body p-4">

            {{-- Nominal + Info Pesanan di paling atas (hanya saat awaiting_payment QRIS/transfer) --}}
            @if($transaction->status == 'awaiting_payment' && in_array($transaction->payment_method, ['qris', 'transfer']))

                @if($transaction->payment_method === 'transfer' && $store->bank_account)
                    <div class="bg-light rounded-3 p-3 mb-3 text-start">
                        <p class="text-muted small mb-1">Transfer ke Rekening {{ $store->bank_name }}:</p>
                        <h5 class="fw-bold text-primary mb-1">{{ $store->bank_account }}</h5>
                        <p class="text-muted small mb-0">a.n. {{ $store->bank_account_name }}</p>
                        <hr class="my-2">
                        <p class="text-muted small mb-1">Total Pembayaran:</p>
                        <p class="fw-bold mb-0">Rp{{ number_format($transaction->total, 0, ',', '.') }}</p>
                    </div>
                @endif

            @endif

            {{-- Info Pesanan --}}
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">No. Pesanan</span>
                <span class="fw-bold">{{ $transaction->invoice }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tanggal</span>
                <span class="fw-bold">{{ $transaction->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Metode Pembayaran</span>
                <span class="fw-bold">{{ $transaction->payment_method == 'qris' ? 'QRIS' : ($transaction->payment_method == 'transfer' ? 'Transfer Bank' : 'Bayar di Tempat') }}</span>
            </div>
            <div class="d-flex justify-content-between pb-3 border-bottom">
                <span class="text-muted">Status</span>
                <span class="fw-bold text-uppercase" style="font-size: 0.9rem;">
                    @if($transaction->status == 'completed')
                        <span class="text-success">Selesai</span>
                    @elseif($transaction->status == 'rejected')
                        <span class="text-danger">Ditolak</span>
                    @else
                        <span class="text-warning text-dark">{{ str_replace('_', ' ', $transaction->status) }}</span>
                    @endif
                </span>
            </div>

            {{-- Form: QRIS image + Upload + Rincian + Tombol (hanya saat awaiting_payment) --}}
            @if($transaction->status == 'awaiting_payment' && in_array($transaction->payment_method, ['qris', 'transfer']))
                <form action="{{ route('customer-kasir.confirm-payment', ['token' => $token->token, 'invoice' => $transaction->invoice]) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Gambar QRIS --}}
                    @if($transaction->payment_method === 'qris' && $store->qris_active && $store->qris_image)
                        <div class="text-center mt-3 mb-3">
                            <p class="fw-semibold mb-2">Scan QRIS untuk Membayar</p>
                            <img src="{{ asset('storage/' . $store->qris_image) }}"
                                 alt="QRIS pembayaran"
                                 class="img-fluid rounded mb-3"
                                 style="max-width: 220px;">
                            <div class="bg-light rounded-3 px-3 py-2">
                                <p class="text-muted small mb-1">Scan kode QR di atas menggunakan e-Wallet Anda.</p>
                                <p class="fw-bold mb-0">Pastikan nominal: <span class="text-primary">Rp{{ number_format($transaction->total, 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    @endif

                    {{-- Upload Bukti --}}
                    <div class="mt-3 mb-3">
                        <label class="form-label small fw-semibold">
                            Upload Bukti Pembayaran <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               name="payment_proof"
                               class="form-control form-control-sm @error('payment_proof') is-invalid @enderror"
                               accept="image/jpeg,image/png"
                               required>
                        <div class="form-text">Format JPG atau PNG. Maks. 5 MB.</div>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Rincian Pesanan --}}
                    <div class="border-top pt-3 mb-3">
                        <div class="fw-bold mb-2">Rincian Pesanan</div>
                        @foreach($transaction->details as $detail)
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>{{ $detail->product->name }} <span class="text-muted">x{{ $detail->quantity }}</span></span>
                                <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between border-top mt-2 pt-2">
                            <span class="fw-bold">Total Bayar</span>
                            <span class="fw-bold text-primary">Rp{{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill">
                        Saya Sudah Membayar
                    </button>
                </form>

            @else

                {{-- Rincian Pesanan (status selain awaiting_payment) --}}
                <div class="mt-3">
                    <div class="fw-bold mb-2">Rincian Pesanan</div>
                    @foreach($transaction->details as $detail)
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>{{ $detail->product->name }} <span class="text-muted">x{{ $detail->quantity }}</span></span>
                            <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between border-top mt-3 pt-3">
                        <span class="fw-bold fs-5">Total Bayar</span>
                        <span class="fw-bold fs-4 text-primary">Rp{{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>
                </div>

            @endif

        </div>
    </div>

    <div class="mt-4 text-center pb-5">
        <p class="text-muted small mb-4">Harap simpan/bookmark halaman ini untuk melacak status pesanan Anda.</p>
        <a href="{{ route('customer-kasir.index', $token->token) }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Belanja Lagi
        </a>
    </div>

</div>

@push('scripts')
@if(in_array($transaction->status, ['pending_approval', 'payment_review']))
<script>
    // Refresh otomatis tiap 10 detik agar pelanggan bisa melihat jika pesanan di-approve
    setTimeout(function() {
        window.location.reload();
    }, 10000);
</script>
@endif
@endpush
@endsection
