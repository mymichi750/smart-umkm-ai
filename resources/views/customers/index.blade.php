<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Pelanggan</h2>
                <p class="text-muted mb-0">Kelola daftar pelanggan Anda.</p>
            </div>
            <a href="{{ route('customers.create') }}" class="btn crud-create-btn">
                <i class="bi bi-plus-lg"></i> Tambah Pelanggan
            </a>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-6">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, email, atau telepon">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="customersTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ Str::limit($customer->address, 70) }}</td>
                                    <td class="text-end">
                                        <div class="crud-actions" role="group" aria-label="Aksi pelanggan">
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary crud-action-btn" title="Lihat detail" aria-label="Lihat detail pelanggan"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-primary crud-action-btn" title="Edit" aria-label="Edit pelanggan"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger crud-action-btn" title="Hapus" aria-label="Hapus pelanggan"><i class="bi bi-trash"></i></button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#customersTable').DataTable({
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
