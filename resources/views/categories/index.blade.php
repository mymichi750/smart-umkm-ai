<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Kategori</h2>
                <p class="text-muted mb-0">Kelola kategori produk.</p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn crud-create-btn">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 80) }}</td>
                                    <td class="text-end">
    <div class="crud-actions" role="group" aria-label="Aksi kategori">

        <a href="{{ route('categories.show', $category) }}"
           class="btn btn-outline-secondary crud-action-btn"
           data-bs-toggle="tooltip"
           title="Lihat Detail"
           aria-label="Lihat detail kategori">

            <i class="bi bi-eye"></i>
        </a>

        <a href="{{ route('categories.edit', $category) }}"
           class="btn btn-outline-primary crud-action-btn"
           data-bs-toggle="tooltip"
           title="Edit"
           aria-label="Edit kategori">

            <i class="bi bi-pencil-square"></i>
        </a>

        <form action="{{ route('categories.destroy', $category) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Hapus kategori ini?');">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-outline-danger crud-action-btn"
                    data-bs-toggle="tooltip"
                    title="Hapus"
                    aria-label="Hapus kategori">

                <i class="bi bi-trash"></i>
            </button>

        </form>

    </div>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
<style>

.category-card{
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(15,23,42,.08);
}

#categoriesTable thead th{
    background:#f8fafc;
    border-bottom:none;
    color:#64748b;
    font-size:.85rem;
    text-transform:uppercase;
    letter-spacing:.5px;
}

#categoriesTable tbody tr{
    transition:.2s;
}

#categoriesTable tbody tr:hover{
    background:#f8fbff;
}

#categoriesTable td{
    vertical-align:middle;
}

.pagination{
    justify-content:center;
}

</style>
@endpush

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#categoriesTable').DataTable({
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
