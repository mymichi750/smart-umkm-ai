<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Produk</h2>
                <p class="text-muted mb-0">Kelola produk yang tersedia di POS.</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn crud-create-btn">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-6">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau SKU produk">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="productsTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>SKU</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">{{ $product->active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="crud-actions" role="group" aria-label="Aksi produk">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary crud-action-btn" title="Lihat detail" aria-label="Lihat detail produk"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary crud-action-btn" title="Edit" aria-label="Edit produk"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger crud-action-btn" title="Hapus" aria-label="Hapus produk"><i class="bi bi-trash"></i></button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#productsTable').DataTable({
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
