@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-clipboard-list"></i> Data Peminjaman</h3>
    <span class="badge bg-secondary fs-6">Total: {{ $peminjaman->total() }}</span>
</div>

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
    @if(request()->anyFilled(['status','sort','direction']))
        <div class="col-auto">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    @endif
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
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
                <td>{{ $item->alat->nama_alat }}</td>
                <td>{{ $item->peminjam->nama }}</td>
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
                    <form action="{{ route('admin.peminjaman.destroy', $item) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus data peminjaman ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-3">Belum ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $peminjaman->links() }}
@endsection