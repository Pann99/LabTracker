@extends('layouts.app')
@section('title', 'Pinjam Alat')

@section('content')
<h3><i class="bi bi-box-arrow-in-down"></i> Pinjam Alat</h3>

<div class="alert alert-light border small">
    <i class="bi bi-person-badge"></i>
    Anda meminjam sebagai: <strong>{{ $peminjam->nama }}</strong>
    ({{ $peminjam->nim_nip }})
</div>

<form action="{{ route('user.peminjaman.store') }}" method="POST"
      class="bg-white p-4 rounded shadow-sm" style="max-width:500px;">
    @csrf

    <div class="mb-3">
        <label class="form-label">Pilih Alat</label>
        <select name="alat_id"
                class="form-select @error('alat_id') is-invalid @enderror">
            <option value="">-- Pilih Alat Tersedia --</option>
            @foreach($alats as $alat)
                <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                    {{ $alat->kode_alat }} — {{ $alat->nama_alat }}
                    ({{ $alat->kategori }})
                </option>
            @endforeach
        </select>
        @error('alat_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if($alats->isEmpty())
            <small class="text-danger">
                <i class="bi bi-exclamation-circle"></i>
                Tidak ada alat tersedia saat ini.
            </small>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam"
               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
               class="form-control @error('tanggal_pinjam') is-invalid @enderror">
        @error('tanggal_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary" {{ $alats->isEmpty() ? 'disabled' : '' }}>
        <i class="bi bi-save"></i> Ajukan Peminjaman
    </button>
    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection