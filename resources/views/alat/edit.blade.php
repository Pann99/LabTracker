@extends('layouts.app')
@section('title', 'Edit Alat')

@section('content')
<h3>Edit Alat</h3>

<form action="{{ route('alat.update', $alat) }}" method="POST"
          class="bg-white p-4 rounded shadow-sm">    

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Kode Alat</label>
        <input type="text"
               name="kode_alat"
               value="{{ old('kode_alat', $alat->kode_alat) }}"
               class="form-control @error('kode_alat') is-invalid @enderror">

        @error('kode_alat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Nama Alat</label>
        <input type="text"
               name="nama_alat"
               value="{{ old('nama_alat', $alat->nama_alat) }}"
               class="form-control @error('nama_alat') is-invalid @enderror">

        @error('nama_alat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Kategori</label>
        <input type="text"
               name="kategori"
               value="{{ old('kategori', $alat->kategori) }}"
               class="form-control @error('kategori') is-invalid @enderror">

        @error('kategori')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="tersedia"
                {{ old('status', $alat->status) == 'tersedia' ? 'selected' : '' }}>
                Tersedia
            </option>

            <option value="dipinjam"
                {{ old('status', $alat->status) == 'dipinjam' ? 'selected' : '' }}>
                Dipinjam
            </option>

            <option value="rusak"
                {{ old('status', $alat->status) == 'rusak' ? 'selected' : '' }}>
                Rusak
            </option>
        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection