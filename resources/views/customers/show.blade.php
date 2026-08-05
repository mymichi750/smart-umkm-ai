<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Detail Pelanggan</h2>
                <p class="text-muted mb-0">Informasi lengkap pelanggan.</p>
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ $customer->name }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $customer->email ?? '-' }}</dd>

                    <dt class="col-sm-3">Telepon</dt>
                    <dd class="col-sm-9">{{ $customer->phone ?? '-' }}</dd>

                    <dt class="col-sm-3">Alamat</dt>
                    <dd class="col-sm-9">{{ $customer->address ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
