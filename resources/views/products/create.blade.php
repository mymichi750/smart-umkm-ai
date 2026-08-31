<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Tambah Produk</h2>
                <p class="text-muted mb-0">Tambahkan produk baru ke dalam stok POS.</p>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        @include('partials.alerts')
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Contoh: Kopi Hitam" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <div class="input-group">
                                <select name="category_id" id="categorySelect" class="form-select" required>
                                    <option value="">Pilih kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-primary" id="btnAddCategory" title="Tambah kategori baru">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                            {{-- Inline form tambah kategori --}}
                            <div id="inlineCategoryForm" class="mt-2 p-3 border rounded bg-light d-none">
                                <p class="mb-2 small fw-semibold text-secondary">Tambah Kategori Baru</p>
                                <div class="d-flex gap-2">
                                    <input type="text" id="newCategoryName" class="form-control form-control-sm" placeholder="Nama kategori..." maxlength="255">
                                    <button type="button" class="btn btn-success btn-sm text-nowrap" id="btnSaveCategory">Simpan</button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="btnCancelCategory">Batal</button>
                                </div>
                                <div id="categoryAlert" class="mt-2 d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control" placeholder="Contoh: KPH-01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" class="form-control" placeholder="Jumlah stok tersedia" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Beli</label>
                            <input type="number" name="purchase_price" min="0" step="0.01" value="{{ old('purchase_price', 0) }}" class="form-control" placeholder="Harga beli/modal" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Jual</label>
                            <input type="number" name="sell_price" min="0" step="0.01" value="{{ old('sell_price', 0) }}" class="form-control" placeholder="Harga jual ke pelanggan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="active" class="form-select" required>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const btnToggle  = document.getElementById('btnAddCategory');
        const panel      = document.getElementById('inlineCategoryForm');
        const nameInput  = document.getElementById('newCategoryName');
        const btnSave    = document.getElementById('btnSaveCategory');
        const btnCancel  = document.getElementById('btnCancelCategory');
        const alertBox   = document.getElementById('categoryAlert');
        const select     = document.getElementById('categorySelect');

        function showAlert(msg, type) {
            alertBox.className = 'mt-2 alert alert-' + type + ' py-1 small';
            alertBox.textContent = msg;
            alertBox.classList.remove('d-none');
        }

        function hideAlert() {
            alertBox.classList.add('d-none');
        }

        btnToggle.addEventListener('click', function () {
            panel.classList.toggle('d-none');
            if (!panel.classList.contains('d-none')) {
                nameInput.value = '';
                hideAlert();
                nameInput.focus();
            }
        });

        btnCancel.addEventListener('click', function () {
            panel.classList.add('d-none');
            hideAlert();
        });

        nameInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); btnSave.click(); }
        });

        btnSave.addEventListener('click', function () {
            const name = nameInput.value.trim();
            if (!name) { showAlert('Nama kategori tidak boleh kosong.', 'warning'); return; }

            btnSave.disabled = true;
            btnSave.textContent = 'Menyimpan...';

            fetch('{{ route('categories.quick-store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ name: name }),
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    var option = new Option(data.category.name, data.category.id, true, true);
                    select.add(option);
                    showAlert('Kategori "' + data.category.name + '" berhasil ditambahkan.', 'success');
                    nameInput.value = '';
                    setTimeout(function() { panel.classList.add('d-none'); }, 1200);
                } else {
                    showAlert('Gagal menyimpan kategori.', 'danger');
                }
            })
            .catch(function() { showAlert('Terjadi kesalahan. Coba lagi.', 'danger'); })
            .finally(function() {
                btnSave.disabled = false;
                btnSave.textContent = 'Simpan';
            });
        });
    })();
    </script>
    @endpush

</x-app-layout>
