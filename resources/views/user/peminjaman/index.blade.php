@extends('layouts.app')
@section('title', 'Peminjaman Saya')

@section('content')

<div class="lt-header">
    <h1>
        <span class="page-icon"><i class="bi bi-clipboard-list"></i></span>
        Peminjaman Saya
    </h1>
    @if($peminjam)
    <button class="btn-lt-primary" data-bs-toggle="modal" data-bs-target="#modalPinjamAlat">
        <i class="bi bi-plus-lg"></i> Pinjam Alat
    </button>
    @endif
</div>

@if(!$peminjam)
    <div class="lt-alert lt-alert-warning">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Akun belum terdaftar sebagai peminjam.</strong><br>
            <span style="font-size:.82rem">Silakan hubungi admin untuk melengkapi data Anda.</span>
        </div>
    </div>
@endif

<form method="GET" id="filterForm">
    <div class="lt-filter-bar">
        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="">-- Semua Status --</option>
            <option value="dipinjam"     {{ request('status') === 'dipinjam'     ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="terlambat"    {{ request('status') === 'terlambat'    ? 'selected' : '' }}>Terlambat</option>
        </select>
        <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="tanggal_pinjam"  {{ request('sort') === 'tanggal_pinjam'  ? 'selected' : '' }}>Tgl Pinjam</option>
            <option value="tanggal_kembali" {{ request('sort') === 'tanggal_kembali' ? 'selected' : '' }}>Tgl Kembali</option>
        </select>
        <select name="direction" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="desc" {{ request('direction') !== 'asc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc"  {{ request('direction') === 'asc'  ? 'selected' : '' }}>Terlama</option>
        </select>
    </div>
</form>

<div class="lt-table-wrap">
    <table class="table lt-table">
        <thead>
            <tr>
                <th>Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $item)
            <tr>
                <td data-label="Alat">
                    <div style="font-weight:600;font-size:.85rem">{{ $item->alat->nama_alat }}</div>
                    <div class="kode-chip mt-1">{{ $item->alat->kode_alat }}</div>
                </td>
                <td data-label="Tgl Pinjam">
                    <span style="font-size:.83rem">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</span>
                </td>
                <td data-label="Tgl Kembali">
                    @if($item->tanggal_kembali)
                        <span style="font-size:.83rem">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</span>
                    @else
                        <span class="text-muted" style="font-size:.8rem">—</span>
                    @endif
                </td>
                <td data-label="Status">
                    @if($item->status === 'dipinjam')
                        <span class="lt-badge lt-badge-amber"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Dipinjam</span>
                    @elseif($item->status === 'terlambat')
                        <span class="lt-badge lt-badge-red"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Terlambat</span>
                    @else
                        <span class="lt-badge lt-badge-green"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Dikembalikan</span>
                    @endif
                </td>
                <td data-label="Aksi" class="action-cell">
                    @if($item->status === 'dipinjam' || $item->status === 'terlambat')
                        <button class="btn-lt-success btn-kembalikan"
                                data-id="{{ $item->id }}"
                                data-alat="{{ $item->alat->nama_alat }}"
                                data-tgl="{{ $item->tanggal_pinjam }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalKembalikan">
                            <i class="bi bi-arrow-return-left"></i> Kembalikan
                        </button>
                    @else
                        <span class="text-muted" style="font-size:.8rem">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="5">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:32px 0">
                        <i class="bi bi-clipboard-x" style="font-size:2rem;color:#CBD5E1"></i>
                        <span>Belum ada riwayat peminjaman.</span>
                        @if($peminjam)
                        <button class="btn-lt-primary mt-1" data-bs-toggle="modal" data-bs-target="#modalPinjamAlat">
                            <i class="bi bi-plus-lg"></i> Mulai Pinjam Alat
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $peminjaman->links() }}</div>

{{-- ── MODAL PINJAM ALAT ── --}}
@if($peminjam)
<div class="modal fade" id="modalPinjamAlat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-down"></i> Pinjam Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div style="background:#F8FAFF;border:1px solid #DBEAFE;border-radius:8px;padding:10px 14px;font-size:.82rem;color:#1E40AF;display:flex;gap:8px;align-items:center;margin-bottom:18px">
                        <i class="bi bi-person-badge-fill"></i>
                        Meminjam sebagai: <strong>{{ $peminjam->nama }}</strong> ({{ $peminjam->nim_nip }})
                    </div>
                    <div class="lt-form-group">
                        <label>Pilih Alat</label>
                        <select name="alat_id"
                                class="form-select @error('alat_id') is-invalid @enderror">
                            <option value="">-- Pilih Alat Tersedia --</option>
                            @foreach($alats as $alat)
                                <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                                    {{ $alat->kode_alat }} — {{ $alat->nama_alat }} ({{ $alat->kategori }})
                                </option>
                            @endforeach
                        </select>
                        @error('alat_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($alats->isEmpty())
                            <p style="color:#DC2626;font-size:.78rem;margin-top:6px">
                                <i class="bi bi-exclamation-circle"></i> Tidak ada alat tersedia saat ini.
                            </p>
                        @endif
                    </div>
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                               class="form-control @error('tanggal_pinjam') is-invalid @enderror">
                        @error('tanggal_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-lt-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-lt-primary" {{ $alats->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-save"></i> Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ── MODAL KEMBALIKAN ── --}}
<div class="modal fade" id="modalKembalikan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-return-left"></i> Kembalikan Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:.85rem;color:#475569;margin-bottom:16px">
                    Kembalikan: <strong id="kembalikan_alat_nama"></strong>
                </p>
                <form id="formKembalikan" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="lt-form-group" style="margin-bottom:0">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tgl_kembali_input"
                               class="form-control @error('tanggal_kembali') is-invalid @enderror"
                               value="{{ date('Y-m-d') }}" required>
                        @error('tanggal_kembali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-lt-ghost" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-lt-success" style="background:#16A34A;color:#fff;border:none;border-radius:7px;padding:7px 16px;font-size:.85rem;font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer">
                    <i class="bi bi-check-circle"></i> Konfirmasi Kembali
                </button>
            </div>
                </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Auto-open pinjam modal jika ada error dari store
@if($errors->any() && !old('tanggal_kembali') && $peminjam)
    new bootstrap.Modal(document.getElementById('modalPinjamAlat')).show();
@endif

document.querySelectorAll('.btn-kembalikan').forEach(btn => {
    btn.addEventListener('click', function () {
        const id    = this.dataset.id;
        const alat  = this.dataset.alat;
        const tgl   = this.dataset.tgl;
        const route = `{{ url('user/peminjaman') }}/${id}/kembalikan`;
        document.getElementById('formKembalikan').action        = route;
        document.getElementById('kembalikan_alat_nama').textContent = alat;
        document.getElementById('tgl_kembali_input').min        = tgl;
    });
});
</script>
@endsection