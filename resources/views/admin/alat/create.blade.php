@extends('layouts.app')
@section('title', 'Tambah Alat')

@section('content')
<h3><i class="bi bi-plus-circle"></i> Tambah Alat</h3>

<form action="{{ route('admin.alat.store') }}" method="POST"
      class="bg-white p-4 rounded shadow-sm" style="max-width:500px;">
    @csrf

    <div class="mb-3">
        <label class="form-label">Kode Alat</label>
        <input type="text" name="kode_alat" value="{{ old('kode_alat') }}"
               class="form-control @error('kode_alat') is-invalid @enderror">
        @error('kode_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Alat</label>
        <input type="text" name="nama_alat" value="{{ old('nama_alat') }}"
               class="form-control @error('nama_alat') is-invalid @enderror">
        @error('nama_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori') }}"
               class="form-control @error('kategori') is-invalid @enderror">
        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="tersedia">Tersedia</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="rusak">Rusak</option>
        </select>
    </div>

    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
    <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection