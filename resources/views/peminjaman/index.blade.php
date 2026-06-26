@extends('layouts.app')
@section('title', 'Peminjaman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Peminjaman</h3>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">+ Peminjaman Baru</a>
</div>

{{-- Filter & Sort (syarat wajib soal) --}}
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
            <option value="tanggal_pinjam" {{ request('sort') === 'tanggal_pinjam' ? 'selected' : '' }}>Urutkan: Tgl Pinjam</option>
            <option value="tanggal_kembali" {{ request('sort') === 'tanggal_kembali' ? 'selected' : '' }}>Urutkan: Tgl Kembali</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="direction" class="form-select" onchange="this.form.submit()">
            <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc"  {{ request('direction') === 'asc'  ? 'selected' : '' }}>Terlama</option>
        </select>
    </div>
    @if(request('status') || request('sort') || request('direction'))
        <div class="col-auto">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    @endif
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>Alat</th>
                <th>Peminjam</th>
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
                <td>{{ $item->peminjam->nama }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{
                        $item->status === 'dipinjam'     ? 'warning'   :
                        ($item->status === 'terlambat'   ? 'danger'    : 'success')
                    }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    @if($item->status === 'dipinjam' || $item->status === 'terlambat')
                    <form action="{{ route('peminjaman.update', $item) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="date"
                               name="tanggal_kembali"
                               class="form-control mb-2 @error('tanggal_kembali') is-invalid @enderror"
                               required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-success btn-sm">Kembalikan</button>
                    </form>
                    @else
                    <span class="text-muted">—</span>
                    @endif

                    <form action="{{ route('peminjaman.destroy', $item) }}"
                          method="POST"
                          class="d-inline mt-1"
                          onsubmit="return confirm('Hapus data peminjaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $peminjaman->links() }}

@endsection