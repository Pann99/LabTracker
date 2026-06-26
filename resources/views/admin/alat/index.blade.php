@extends('layouts.app')
@section('title', 'Daftar Alat')

@section('content')

{{-- PAGE HEADER --}}
<div class="lt-header">
    <h1>
        <span class="page-icon"><i class="bi bi-tools"></i></span>
        Daftar Alat Laboratorium
    </h1>
    <button class="btn-lt-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAlat">
        <i class="bi bi-plus-lg"></i> Tambah Alat
    </button>
</div>

{{-- FILTER BAR --}}
<form method="GET" id="filterForm">
    <div class="lt-filter-bar">
        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="">-- Semua Status --</option>
            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="rusak"    {{ request('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
        </select>

        @if(request('status'))
            <a href="{{ route('admin.alat.index') }}" class="btn-lt-ghost">
                <i class="bi bi-x"></i> Reset
            </a>
        @endif

        <span class="ms-auto text-muted" style="font-size:.8rem">
            {{ $alats->total() }} alat ditemukan
        </span>
    </div>
</form>

{{-- TABLE --}}
<div class="lt-table-wrap">
    <table class="table lt-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_alat', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                        Nama Alat
                        <i class="bi bi-arrow-down-up ms-1" style="font-size:.7rem;opacity:.6"></i>
                    </a>
                </th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alats as $alat)
            <tr>
                <td data-label="Kode">
                    <span class="kode-chip">{{ $alat->kode_alat }}</span>
                </td>
                <td data-label="Nama Alat">{{ $alat->nama_alat }}</td>
                <td data-label="Kategori">{{ $alat->kategori }}</td>
                <td data-label="Status">
                    @if($alat->status === 'tersedia')
                        <span class="lt-badge lt-badge-green"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Tersedia</span>
                    @elseif($alat->status === 'dipinjam')
                        <span class="lt-badge lt-badge-amber"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Dipinjam</span>
                    @else
                        <span class="lt-badge lt-badge-red"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Rusak</span>
                    @endif
                </td>
                <td data-label="Aksi" class="action-cell">
                    <div class="action-group">
                        <button class="btn-lt-ghost btn-edit-alat"
                                data-id="{{ $alat->id }}"
                                data-kode="{{ $alat->kode_alat }}"
                                data-nama="{{ $alat->nama_alat }}"
                                data-kategori="{{ $alat->kategori }}"
                                data-status="{{ $alat->status }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditAlat">
                            <i class="bi bi-pencil"></i> Ubah
                        </button>
                        <button class="btn-lt-danger btn-hapus-alat"
                                data-id="{{ $alat->id }}"
                                data-nama="{{ $alat->nama_alat }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapusAlat">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="5">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:32px 0">
                        <i class="bi bi-inbox" style="font-size:2rem;color:#CBD5E1"></i>
                        <span>Belum ada data alat.</span>
                        <button class="btn-lt-primary mt-1" data-bs-toggle="modal" data-bs-target="#modalTambahAlat">
                            <i class="bi bi-plus-lg"></i> Tambah Alat Pertama
                        </button>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $alats->links() }}</div>

{{-- ── MODAL TAMBAH ── --}}
<div class="modal fade" id="modalTambahAlat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.alat.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="lt-form-group">
                        <label>Kode Alat</label>
                        <input type="text" name="kode_alat"
                               value="{{ old('kode_alat') }}"
                               class="form-control @error('kode_alat') is-invalid @enderror"
                               placeholder="contoh: ALT-001">
                        @error('kode_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="lt-form-group">
                        <label>Nama Alat</label>
                        <input type="text" name="nama_alat"
                               value="{{ old('nama_alat') }}"
                               class="form-control @error('nama_alat') is-invalid @enderror"
                               placeholder="Nama lengkap alat">
                        @error('nama_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="lt-form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori"
                               value="{{ old('kategori') }}"
                               class="form-control @error('kategori') is-invalid @enderror"
                               placeholder="contoh: Optik, Kimia, Elektronik">
                        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="rusak"    {{ old('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-lt-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-lt-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div class="modal fade" id="modalEditAlat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditAlat" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="lt-form-group">
                        <label>Kode Alat</label>
                        <input type="text" name="kode_alat" id="edit_kode_alat"
                               class="form-control" required>
                    </div>
                    <div class="lt-form-group">
                        <label>Nama Alat</label>
                        <input type="text" name="nama_alat" id="edit_nama_alat"
                               class="form-control" required>
                    </div>
                    <div class="lt-form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" id="edit_kategori"
                               class="form-control" required>
                    </div>
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-lt-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-lt-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── MODAL HAPUS ── --}}
<div class="modal fade" id="modalHapusAlat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#7F1D1D">
                <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2rem"></i>
                <p class="mt-3 mb-1" style="font-size:.9rem;font-weight:600;color:#1E293B">
                    Hapus alat ini?
                </p>
                <p class="text-muted" style="font-size:.82rem">
                    <strong id="hapus_nama_alat"></strong> akan dihapus permanen.
                </p>
            </div>
            <form id="formHapusAlat" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn-lt-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-lt-primary" style="background:#DC2626">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ── Auto-open modal jika ada validation error (dari store/update) ──
@if($errors->any() && old('_method') === 'PUT')
    new bootstrap.Modal(document.getElementById('modalEditAlat')).show();
@elseif($errors->any() && !old('_method'))
    new bootstrap.Modal(document.getElementById('modalTambahAlat')).show();
@endif

// ── Edit modal populate ──
document.querySelectorAll('.btn-edit-alat').forEach(btn => {
    btn.addEventListener('click', function () {
        const id       = this.dataset.id;
        const route    = `{{ url('admin/alat') }}/${id}`;
        document.getElementById('formEditAlat').action = route;
        document.getElementById('edit_kode_alat').value  = this.dataset.kode;
        document.getElementById('edit_nama_alat').value  = this.dataset.nama;
        document.getElementById('edit_kategori').value   = this.dataset.kategori;
        document.getElementById('edit_status').value     = this.dataset.status;
    });
});

// ── Hapus modal populate ──
document.querySelectorAll('.btn-hapus-alat').forEach(btn => {
    btn.addEventListener('click', function () {
        const id    = this.dataset.id;
        const nama  = this.dataset.nama;
        const route = `{{ url('admin/alat') }}/${id}`;
        document.getElementById('formHapusAlat').action   = route;
        document.getElementById('hapus_nama_alat').textContent = nama;
    });
});
</script>
@endsection