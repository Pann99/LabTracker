<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AlatController as AdminAlatController;
use App\Http\Controllers\Admin\PeminjamController as AdminPeminjamController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Models\Alat;

// ── Root redirect ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.alat.index')
            : redirect()->route('user.peminjaman.index');
    }
    return redirect()->route('login');
});

// ── Endpoint JSON (nilai tambah soal) ─────────────────────────────────────────
Route::get('/api/alat', function () {
    return response()->json(Alat::all());
});

// ── Auth routes ───────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

// ── Admin routes ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

    // Kelola Alat
    Route::resource('alat', AdminAlatController::class)->except(['show']);

    // Kelola Peminjam
    Route::resource('peminjam', AdminPeminjamController::class)->except(['show']);

    // Lihat & Hapus Peminjaman
    Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::delete('peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

// ── User routes ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])
     ->prefix('user')
     ->name('user.')
     ->group(function () {

    // Riwayat & Buat Peminjaman
    Route::get('peminjaman',          [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/buat',     [UserPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman',         [UserPeminjamanController::class, 'store'])->name('peminjaman.store');

    // Kembalikan Alat
    Route::patch('peminjaman/{peminjaman}/kembalikan',
        [UserPeminjamanController::class, 'kembalikan']
    )->name('peminjaman.kembalikan');
});