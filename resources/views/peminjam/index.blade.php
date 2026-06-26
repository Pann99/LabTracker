@extends('layouts.app')
@section('title', 'Daftar Peminjam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Peminjam</h3>
    <a href="{{ route('peminjam.create') }}" class="btn btn-primary">+ Tambah Peminjam</a>
</div>

{{-- Fitur pencarian (nilai tambah soal) --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama peminjam..."
               class="form-control">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('peminjam.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIM/NIP</th>
                <th>Kontak</th>
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
                    <a href="{{ route('peminjam.edit', $peminjam) }}"
                       class="btn btn-sm btn-outline-secondary">Ubah</a>

                    <form action="{{ route('peminjam.destroy', $peminjam) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Hapus peminjam ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada data peminjam.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $peminjams->links() }}
@endsection