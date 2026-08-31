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

        {{-- Panel pengajuan premium yang menunggu verifikasi --}}
        @php($pendingUsers = \App\Models\User::whereNotNull('premium_pending_level')->get())
        @if($pendingUsers->count() > 0)
        <div class="card shadow-sm border-warning mb-4">
            <div class="card-header d-flex align-items-center gap-2 border-warning" style="background: rgba(234,179,8,.08);">
                <i class="bi bi-hourglass-split text-warning"></i>
                <span class="fw-bold">Pengajuan Premium Menunggu Verifikasi</span>
                <span class="badge bg-warning text-dark ms-1">{{ $pendingUsers->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="text-muted small">
                            <tr>
                                <th class="ps-3">Pengguna</th>
                                <th>Paket Diminta</th>
                                <th>Paket Saat Ini</th>
                                <th>Bukti Bayar</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $pu)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-semibold">{{ $pu->name }}</div>
                                    <div class="text-muted small">{{ $pu->email }}</div>
                                </td>
                                <td><span class="badge bg-primary">Premium {{ $pu->premium_pending_level }}</span></td>
                                <td><span class="badge bg-secondary">Premium {{ $pu->premium_level ?? 1 }}</span></td>
                                <td>
                                    @if($pu->premium_proof_path)
                                        <a href="{{ route('premium.proof', $pu) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-image me-1"></i>Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-muted small">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <form action="{{ route('premium.approve', $pu) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan Premium {{ $pu->premium_pending_level }} untuk {{ $pu->name }}?')">
                                            <i class="bi bi-check-lg me-1"></i>Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('premium.reject', $pu) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak pengajuan premium {{ $pu->name }}?')">
                                            <i class="bi bi-x-lg me-1"></i>Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="filter-bar mb-4">
                    <div class="filter-search">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau email">
                    </div>
                    <div class="filter-select">
                        <select name="role" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                    </div>
                    <div class="filter-select">
                        <select name="sort" class="form-select">
                            <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>A - Z</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>
                    <div class="filter-action">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0" id="usersTable">
                        <thead class="text-secondary" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
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
                                    <td data-label="Nama">{{ $user->name }}</td>
                                    <td data-label="Email">{{ $user->email }}</td>
                                    <td data-label="Role">{{ ucfirst($user->role) }}</td>
                                    <td data-label="Telepon">{{ $user->phone }}</td>
                                    <td class="text-end">
                                        <div class="crud-actions" role="group" aria-label="Aksi pengguna">
                                        <a href="{{ route('users.show', $user) }}" class="btn bg-secondary bg-opacity-10 text-secondary border-0 rounded-circle crud-action-btn" title="Lihat detail" aria-label="Lihat detail pengguna"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn bg-primary bg-opacity-10 text-primary border-0 rounded-circle crud-action-btn" title="Edit" aria-label="Edit pengguna"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-danger bg-opacity-10 text-danger border-0 rounded-circle crud-action-btn" title="Hapus" aria-label="Hapus pengguna"><i class="bi bi-trash"></i></button>
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

    @push('styles')
<style>
.table > :not(caption) > * > * {
    padding: 1rem 1rem;
}
</style>
    @endpush
</x-app-layout>
