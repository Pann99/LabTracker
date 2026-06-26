@extends('layouts.app')
@section('title', 'Tambah Peminjaman')

@section('content')

<h3>Tambah Peminjaman</h3>

<form action="{{ route('peminjaman.store') }}"
      method="POST"
      class="bg-white p-4 rounded shadow-sm"
      style="max-width:500px;">

    @csrf

    <div class="mb-3">
        <label class="form-label">Alat</label>
        <select name="alat_id"
                class="form-select @error('alat_id') is-invalid @enderror">
            <option value="">-- Pilih Alat --</option>
            @foreach($alats as $alat)
                <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                    {{ $alat->kode_alat }} - {{ $alat->nama_alat }}
                </option>
            @endforeach
        </select>
        @error('alat_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if($alats->isEmpty())
            <small class="text-danger">Tidak ada alat tersedia saat ini.</small>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Peminjam</label>
        <select name="peminjam_id"
                class="form-select @error('peminjam_id') is-invalid @enderror">
            <option value="">-- Pilih Peminjam --</option>
            @foreach($peminjams as $peminjam)
                <option value="{{ $peminjam->id }}" {{ old('peminjam_id') == $peminjam->id ? 'selected' : '' }}>
                    {{ $peminjam->nama }} ({{ $peminjam->nim_nip }})
                </option>
            @endforeach
        </select>
        @error('peminjam_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Pinjam</label>
        <input type="date"
               name="tanggal_pinjam"
               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
               class="form-control @error('tanggal_pinjam') is-invalid @enderror">
        @error('tanggal_pinjam')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>

</form>

@endsection