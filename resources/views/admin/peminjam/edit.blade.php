@extends('layouts.app')
@section('title', 'Edit Peminjam')

@section('content')
<h3><i class="bi bi-person-gear"></i> Edit Peminjam</h3>

<form action="{{ route('admin.peminjam.update', $peminjam) }}" method="POST"
      class="bg-white p-4 rounded shadow-sm" style="max-width:500px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama"
               value="{{ old('nama', $peminjam->nama) }}"
               class="form-control @error('nama') is-invalid @enderror">
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">NIM/NIP</label>
        <input type="text" name="nim_nip"
               value="{{ old('nim_nip', $peminjam->nim_nip) }}"
               class="form-control @error('nim_nip') is-invalid @enderror">
        @error('nim_nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kontak <span class="text-muted">(email akun user)</span></label>
        <input type="text" name="kontak"
               value="{{ old('kontak', $peminjam->kontak) }}"
               class="form-control @error('kontak') is-invalid @enderror">
        @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
    <a href="{{ route('admin.peminjam.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection