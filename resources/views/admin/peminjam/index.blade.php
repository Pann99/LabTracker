@extends('layouts.app')
@section('title', 'Daftar Peminjam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-people"></i> Daftar Peminjam</h3>
    <a href="{{ route('admin.peminjam.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Peminjam
    </a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama peminjam..." class="form-control">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.peminjam.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>NIM/NIP</th>
                <th>Kontak (Email)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjams as $peminjam)
            <tr>
                <td>{{ $peminjam->nama }}</td>
                <td>{{ $peminjam->nim_nip }}</td>
                <td>{{ $peminjam->kontak ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.peminjam.edit', $peminjam) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Ubah
                    </a>
                    <form action="{{ route('admin.peminjam.destroy', $peminjam) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus peminjam ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-3">Belum ada data peminjam.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $peminjams->links() }}
@endsection