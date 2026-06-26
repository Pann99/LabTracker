@extends('layouts.app')
@section('title', 'Edit Alat')

@section('content')
<h3><i class="bi bi-pencil-square"></i> Edit Alat</h3>

<form action="{{ route('admin.alat.update', $alat) }}" method="POST"
      class="bg-white p-4 rounded shadow-sm" style="max-width:500px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Kode Alat</label>
        <input type="text" name="kode_alat"
               value="{{ old('kode_alat', $alat->kode_alat) }}"
               class="form-control @error('kode_alat') is-invalid @enderror">
        @error('kode_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Alat</label>
        <input type="text" name="nama_alat"
               value="{{ old('nama_alat', $alat->nama_alat) }}"
               class="form-control @error('nama_alat') is-invalid @enderror">
        @error('nama_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori"
               value="{{ old('kategori', $alat->kategori) }}"
               class="form-control @error('kategori') is-invalid @enderror">
        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['tersedia','dipinjam','rusak'] as $s)
            <option value="{{ $s }}" {{ old('status', $alat->status) === $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
    <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection