<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Pengguna</h2>
                <p class="text-muted mb-0">Kelola akun admin dan kasir.</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn crud-create-btn">
                <i class="bi bi-plus-lg"></i> Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-6">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau email">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="usersTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="text-end">
                                        <div class="crud-actions" role="group" aria-label="Aksi pengguna">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary crud-action-btn" title="Lihat detail" aria-label="Lihat detail pengguna"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary crud-action-btn" title="Edit" aria-label="Edit pengguna"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger crud-action-btn" title="Hapus" aria-label="Hapus pengguna"><i class="bi bi-trash"></i></button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#usersTable').DataTable({
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
