<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="h4 mb-1">Laporan Kas & Penjualan</h2>
            <p class="text-muted mb-0">Pantau penjualan, penambahan dana, pengeluaran, dan pembelian stok.</p>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label" for="start">Tanggal Mulai</label>
                        <input id="start" type="date" name="start" value="{{ request('start', $start->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="end">Tanggal Akhir</label>
                        <input id="end" type="date" name="end" value="{{ request('end', $end->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @php $closingBalance = $openingBalance + $sales + $capital - $expenses; @endphp
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-muted">Saldo Awal</small><h5 class="mb-0">Rp {{ number_format($openingBalance, 0, ',', '.') }}</h5></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-muted">Kas Masuk</small><h5 class="mb-0 text-success">Rp {{ number_format($sales + $capital, 0, ',', '.') }}</h5><small class="text-muted">Penjualan & tambah dana</small></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-muted">Kas Keluar</small><h5 class="mb-0 text-danger">Rp {{ number_format($expenses, 0, ',', '.') }}</h5><small class="text-muted">Operasional & pembelian stok</small></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card border-0 shadow-sm h-100 bg-primary text-white"><div class="card-body"><small class="text-white-50">Saldo Akhir</small><h5 class="mb-0">Rp {{ number_format($closingBalance, 0, ',', '.') }}</h5></div></div></div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white"><strong><i class="bi bi-wallet2 me-2"></i>Catat Mutasi Kas</strong></div>
                    <div class="card-body">
                        <form action="{{ route('reports.cash-flow.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="type">Jenis Mutasi</label>
                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="capital" @selected(old('type') === 'capital')>Penambahan Dana</option>
                                    <option value="expense" @selected(old('type') === 'expense')>Pengeluaran Operasional</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="amount">Nominal</label>
                                <input id="amount" type="number" name="amount" min="1" step="0.01" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" required>
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Keterangan</label>
                                <input id="description" name="description" maxlength="255" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" placeholder="Contoh: Bayar listrik warung" required>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button class="btn btn-primary w-100"><i class="bi bi-plus-circle me-1"></i>Simpan Mutasi</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white"><strong><i class="bi bi-file-earmark-bar-graph me-2"></i>Ringkasan Periode</strong></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between border-bottom py-2"><span>Penjualan kasir</span><strong class="text-success">+ Rp {{ number_format($sales, 0, ',', '.') }}</strong></div>
                        <div class="d-flex justify-content-between border-bottom py-2"><span>Penambahan dana</span><strong class="text-success">+ Rp {{ number_format($capital, 0, ',', '.') }}</strong></div>
                        <div class="d-flex justify-content-between border-bottom py-2"><span>Pengeluaran & pembelian stok</span><strong class="text-danger">− Rp {{ number_format($expenses, 0, ',', '.') }}</strong></div>
                        <div class="d-flex justify-content-between pt-3"><strong>Perubahan saldo</strong><strong>Rp {{ number_format($sales + $capital - $expenses, 0, ',', '.') }}</strong></div>
                        <p class="small text-muted mb-0 mt-3">Setiap produk baru atau stok yang ditambah akan otomatis tercatat sebagai pembelian stok berdasarkan harga beli.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('reports.export.pdf') }}" method="POST" class="d-inline-block me-2">
                    @csrf
                    <input type="hidden" name="start" value="{{ request('start', $start->format('Y-m-d')) }}">
                    <input type="hidden" name="end" value="{{ request('end', $end->format('Y-m-d')) }}">
                    <button class="btn btn-outline-danger">Export PDF Penjualan</button>
                </form>
                <form action="{{ route('reports.export.excel') }}" method="POST" class="d-inline-block">
                    @csrf
                    <input type="hidden" name="start" value="{{ request('start', $start->format('Y-m-d')) }}">
                    <input type="hidden" name="end" value="{{ request('end', $end->format('Y-m-d')) }}">
                    <button class="btn btn-outline-success">Export Excel Penjualan</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong><i class="bi bi-clock-history me-2"></i>Histori Mutasi</strong></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light"><tr><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th>Kasir</th><th class="text-end">Masuk</th><th class="text-end">Keluar</th></tr></thead>
                        <tbody>
                            @forelse($entries as $entry)
                                <tr>
                                    <td>{{ $entry->date->format('d M Y H:i') }}</td>
                                    <td><span class="cash-type cash-type--{{ $entry->category }}">{{ $entry->type }}</span></td>
                                    <td>{{ $entry->description }}</td>
                                    <td>{{ $entry->user }}</td>
                                    <td class="text-end text-success">{{ $entry->in ? 'Rp '.number_format($entry->in, 0, ',', '.') : '—' }}</td>
                                    <td class="text-end text-danger">{{ $entry->out ? 'Rp '.number_format($entry->out, 0, ',', '.') : '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada mutasi pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $entries->links() }}</div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .cash-type {
                display: inline-flex;
                align-items: center;
                min-width: max-content;
                padding: .35rem .6rem;
                border-radius: .45rem;
                font-size: .75rem;
                font-weight: 700;
                line-height: 1;
                color: #fff;
            }
            .cash-type--sale { background: #087f5b; }
            .cash-type--capital { background: #0d8a5a; }
            .cash-type--stock { background: #b45309; }
            .cash-type--expense { background: #dc3545; }
        </style>
    @endpush
</x-app-layout>
