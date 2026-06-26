@extends('layouts.app')
@section('title', 'Peminjaman Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-clipboard-list"></i> Peminjaman Saya</h3>
    <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Pinjam Alat
    </a>
</div>

@if(!$peminjam)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        Akun Anda belum terdaftar sebagai peminjam. Silakan hubungi admin untuk mendaftarkan data Anda.
    </div>
@endif

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="dipinjam"     {{ request('status') === 'dipinjam'     ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="terlambat"    {{ request('status') === 'terlambat'    ? 'selected' : '' }}>Terlambat</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="tanggal_pinjam"  {{ request('sort') === 'tanggal_pinjam'  ? 'selected' : '' }}>Tgl Pinjam</option>
            <option value="tanggal_kembali" {{ request('sort') === 'tanggal_kembali' ? 'selected' : '' }}>Tgl Kembali</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="direction" class="form-select" onchange="this.form.submit()">
            <option value="desc" {{ request('direction') !== 'asc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc"  {{ request('direction') === 'asc'  ? 'selected' : '' }}>Terlama</option>
        </select>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
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
                <td>{{ $item->alat->nama_alat }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{
                        $item->status === 'dipinjam'     ? 'warning text-dark' :
                        ($item->status === 'terlambat'   ? 'danger'            : 'success')
                    }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    @if($item->status === 'dipinjam' || $item->status === 'terlambat')
                    <form action="{{ route('user.peminjaman.kembalikan', $item) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="input-group input-group-sm">
                            <input type="date" name="tanggal_kembali"
                                   class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                   value="{{ date('Y-m-d') }}" required>
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                            </button>
                        </div>
                        @error('tanggal_kembali')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </form>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    Belum ada riwayat peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $peminjaman->links() }}
@endsection