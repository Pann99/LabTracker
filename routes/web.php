<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Alat;

Route::get('/', fn() => redirect()->route('alat.index'));

Route::get('/api/alat', function () {
    return response()->json(Alat::all());
});

Route::resource('alat', AlatController::class)->except(['show']);
Route::resource('peminjam', PeminjamController::class)->except(['show']);
Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'create', 'store']);
Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'update'])->name('peminjaman.update');