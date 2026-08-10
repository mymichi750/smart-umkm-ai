<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Detail Produk</h2>
                <p class="text-muted mb-0">Informasi lengkap produk.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">Edit</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $product->name }}</dd>

                    <dt class="col-sm-4">Kategori</dt>
                    <dd class="col-sm-8">{{ $product->category->name ?? '-' }}</dd>

                    <dt class="col-sm-4">SKU</dt>
                    <dd class="col-sm-8">{{ $product->sku }}</dd>

                    <dt class="col-sm-4">Harga Beli</dt>
                    <dd class="col-sm-8">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4">Harga Jual</dt>
                    <dd class="col-sm-8">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4">Stok</dt>
                    <dd class="col-sm-8">{{ $product->stock }}</dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8"><span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">{{ $product->active ? 'Aktif' : 'Nonaktif' }}</span></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">{{ $product->description ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
