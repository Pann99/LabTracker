@extends('layouts.app')
@section('title', 'Daftar Peminjam')

@section('content')

<div class="lt-header">
    <h1>
        <span class="page-icon"><i class="bi bi-people"></i></span>
        Daftar Peminjam
    </h1>
    <button class="btn-lt-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjam">
        <i class="bi bi-person-plus"></i> Tambah Peminjam
    </button>
</div>

{{-- SEARCH BAR --}}
<form method="GET" id="searchForm">
    <div class="lt-filter-bar">
        <div style="position:relative;flex:1;max-width:320px">
            <i class="bi bi-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94A3B8;font-size:.85rem"></i>
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   style="padding-left:32px"
                   placeholder="Cari nama peminjam...">
        </div>
        <button type="submit" class="btn-lt-primary" style="height:36px;padding:0 14px">
            <i class="bi bi-search"></i> Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.peminjam.index') }}" class="btn-lt-ghost">
                <i class="bi bi-x"></i> Reset
            </a>
        @endif
        <span class="ms-auto text-muted" style="font-size:.8rem">
            {{ $peminjams->total() }} peminjam ditemukan
        </span>
    </div>
</form>

<div class="lt-table-wrap">
    <table class="table lt-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM / NIP</th>
                <th>Email (Kontak)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjams as $peminjam)
            <tr>
                <td data-label="Nama">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;background:#EFF6FF;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#2563EB;font-size:.75rem;font-weight:700;flex-shrink:0">
                            {{ strtoupper(substr($peminjam->nama,0,1)) }}
                        </div>
                        {{ $peminjam->nama }}
                    </div>
                </td>
                <td data-label="NIM/NIP">
                    <span class="kode-chip">{{ $peminjam->nim_nip }}</span>
                </td>
                <td data-label="Email">{{ $peminjam->kontak ?? '—' }}</td>
                <td data-label="Aksi" class="action-cell">
                    <div class="action-group">
                        <button class="btn-lt-ghost btn-edit-peminjam"
                                data-id="{{ $peminjam->id }}"
                                data-nama="{{ $peminjam->nama }}"
                                data-nim="{{ $peminjam->nim_nip }}"
                                data-kontak="{{ $peminjam->kontak }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditPeminjam">
                            <i class="bi bi-pencil"></i> Ubah
                        </button>
                        <button class="btn-lt-danger btn-hapus-peminjam"
                                data-id="{{ $peminjam->id }}"
                                data-nama="{{ $peminjam->nama }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapusPeminjam">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="4">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:32px 0">
                        <i class="bi bi-people" style="font-size:2rem;color:#CBD5E1"></i>
                        <span>Belum ada data peminjam.</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $peminjams->links() }}</div>

{{-- ── MODAL TAMBAH ── --}}
<div class="modal fade" id="modalTambahPeminjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Tambah Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjam.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="lt-alert lt-alert-info" style="margin-bottom:16px;padding:10px 14px;background:#EFF6FF;color:#1E40AF;border-left:3px solid #2563EB;border-radius:8px;font-size:.82rem;display:flex;gap:8px">
                        <i class="bi bi-info-circle-fill"></i>
                        Isi <strong>Kontak</strong> dengan email akun user agar peminjam bisa mengakses sistem.
                    </div>
                    <div class="lt-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama"
                               value="{{ old('nama') }}"
                               class="form-control @error('nama') is-invalid @enderror"
                               placeholder="Nama lengkap peminjam">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="lt-form-group">
                        <label>NIM / NIP</label>
                        <input type="text" name="nim_nip"
                               value="{{ old('nim_nip') }}"
                               class="form-control @error('nim_nip') is-invalid @enderror"
                               placeholder="Nomor induk">
                        @error('nim_nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Email (Kontak)</label>
                        <input type="text" name="kontak"
                               value="{{ old('kontak') }}"
                               class="form-control @error('kontak') is-invalid @enderror"
                               placeholder="email@contoh.com">
                        @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
<div class="modal fade" id="modalEditPeminjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-gear"></i> Edit Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditPeminjam" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="lt-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama"
                               class="form-control" required>
                    </div>
                    <div class="lt-form-group">
                        <label>NIM / NIP</label>
                        <input type="text" name="nim_nip" id="edit_nim_nip"
                               class="form-control" required>
                    </div>
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Email (Kontak)</label>
                        <input type="text" name="kontak" id="edit_kontak"
                               class="form-control">
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
<div class="modal fade" id="modalHapusPeminjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#7F1D1D">
                <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Peminjam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2rem"></i>
                <p class="mt-3 mb-1" style="font-size:.9rem;font-weight:600;color:#1E293B">Hapus peminjam ini?</p>
                <p class="text-muted" style="font-size:.82rem">
                    <strong id="hapus_nama_peminjam"></strong> akan dihapus permanen beserta data terkait.
                </p>
            </div>
            <form id="formHapusPeminjam" method="POST">
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
document.querySelectorAll('.btn-edit-peminjam').forEach(btn => {
    btn.addEventListener('click', function () {
        const id    = this.dataset.id;
        const route = `{{ url('admin/peminjam') }}/${id}`;
        document.getElementById('formEditPeminjam').action = route;
        document.getElementById('edit_nama').value    = this.dataset.nama;
        document.getElementById('edit_nim_nip').value = this.dataset.nim;
        document.getElementById('edit_kontak').value  = this.dataset.kontak || '';
    });
});

document.querySelectorAll('.btn-hapus-peminjam').forEach(btn => {
    btn.addEventListener('click', function () {
        const id    = this.dataset.id;
        const route = `{{ url('admin/peminjam') }}/${id}`;
        document.getElementById('formHapusPeminjam').action       = route;
        document.getElementById('hapus_nama_peminjam').textContent = this.dataset.nama;
    });
});
</script>
@endsection