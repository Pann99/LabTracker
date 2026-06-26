@extends('layouts.app')
@section('title', 'Daftar Alat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-tools"></i> Daftar Alat Laboratorium</h3>
    <a href="{{ route('admin.alat.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Alat
    </a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="rusak"    {{ request('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
        </select>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>
                    <a class="text-white text-decoration-none"
                       href="{{ request()->fullUrlWithQuery(['sort' => 'nama_alat', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                        Nama Alat ⇅
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
                <td><code>{{ $alat->kode_alat }}</code></td>
                <td>{{ $alat->nama_alat }}</td>
                <td>{{ $alat->kategori }}</td>
                <td>
                    <span class="badge bg-{{ $alat->status === 'tersedia' ? 'success' : ($alat->status === 'dipinjam' ? 'warning text-dark' : 'danger') }}">
                        {{ ucfirst($alat->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.alat.edit', $alat) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Ubah
                    </a>
                    <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Hapus alat ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-3">Belum ada data alat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $alats->links() }}
@endsection