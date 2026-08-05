<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Detail Kategori</h2>
                <p class="text-muted mb-0">Informasi kategori produk.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ $category->name }}</dd>

                    <dt class="col-sm-3">Slug</dt>
                    <dd class="col-sm-9">{{ $category->slug }}</dd>

                    <dt class="col-sm-3">Deskripsi</dt>
                    <dd class="col-sm-9">{{ $category->description ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
