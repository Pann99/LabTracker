@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')

<div class="lt-header">
    <h1>
        <span class="page-icon"><i class="bi bi-clipboard-list"></i></span>
        Data Peminjaman
    </h1>
    <span class="lt-badge lt-badge-blue" style="font-size:.8rem;padding:6px 12px">
        Total: {{ $peminjaman->total() }}
    </span>
</div>

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
        @if(request()->anyFilled(['status','sort','direction']))
            <a href="{{ route('admin.peminjaman.index') }}" class="btn-lt-ghost">
                <i class="bi bi-x"></i> Reset
            </a>
        @endif
    </div>
</form>

<div class="lt-table-wrap">
    <table class="table lt-table">
        <thead>
            <tr>
                <th>Alat</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $item)
            <tr>
                <td data-label="Alat">
                    <div>
                        <div style="font-weight:600;font-size:.85rem">{{ $item->alat->nama_alat }}</div>
                        <div class="kode-chip mt-1">{{ $item->alat->kode_alat }}</div>
                    </div>
                </td>
                <td data-label="Peminjam">{{ $item->peminjam->nama }}</td>
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
                    <button class="btn-lt-danger btn-hapus-pinjaman"
                            data-id="{{ $item->id }}"
                            data-alat="{{ $item->alat->nama_alat }}"
                            data-peminjam="{{ $item->peminjam->nama }}"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapusPeminjaman">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="6">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:32px 0">
                        <i class="bi bi-clipboard-x" style="font-size:2rem;color:#CBD5E1"></i>
                        <span>Belum ada data peminjaman.</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $peminjaman->links() }}</div>

{{-- ── MODAL HAPUS PEMINJAMAN ── --}}
<div class="modal fade" id="modalHapusPeminjaman" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#7F1D1D">
                <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2rem"></i>
                <p class="mt-3 mb-1" style="font-size:.9rem;font-weight:600;color:#1E293B">
                    Hapus data peminjaman ini?
                </p>
                <p class="text-muted" style="font-size:.82rem">
                    <strong id="hapus_alat_nama"></strong> oleh <strong id="hapus_peminjam_nama"></strong>
                </p>
            </div>
            <form id="formHapusPeminjaman" method="POST">
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
document.querySelectorAll('.btn-hapus-pinjaman').forEach(btn => {
    btn.addEventListener('click', function () {
        const id      = this.dataset.id;
        const route   = `{{ url('admin/peminjaman') }}/${id}`;
        document.getElementById('formHapusPeminjaman').action = route;
        document.getElementById('hapus_alat_nama').textContent     = this.dataset.alat;
        document.getElementById('hapus_peminjam_nama').textContent  = this.dataset.peminjam;
    });
});
</script>
@endsection