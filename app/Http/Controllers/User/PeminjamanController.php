<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan riwayat peminjaman milik user yang sedang login.
     * Cocokkan berdasarkan email user == kontak peminjam,
     * atau kita buat relasi lewat peminjam_id yang terhubung ke user.
     */
    public function index(Request $request)
    {
        // Cari data peminjam yang emailnya sama dengan user login
        $peminjam = Peminjam::where('kontak', Auth::user()->email)->first();

        $query = Peminjaman::with(['alat', 'peminjam'])
                            ->where('peminjam_id', optional($peminjam)->id ?? 0);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortable  = ['tanggal_pinjam', 'tanggal_kembali'];
        $sortBy    = in_array($request->sort, $sortable) ? $request->sort : 'tanggal_pinjam';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $peminjaman = $query->orderBy($sortBy, $direction)
                            ->paginate(10)
                            ->withQueryString();

        return view('user.peminjaman.index', compact('peminjaman', 'peminjam'));
    }

    public function create()
    {
        // Cek apakah user sudah terdaftar sebagai peminjam
        $peminjam = Peminjam::where('kontak', Auth::user()->email)->first();

        if (!$peminjam) {
            return redirect()->route('user.peminjaman.index')
                             ->with('error', 'Akun Anda belum terdaftar sebagai peminjam. Hubungi admin.');
        }

        $alats = Alat::where('status', 'tersedia')->get();

        return view('user.peminjaman.create', compact('alats', 'peminjam'));
    }

    public function store(Request $request)
    {
        $peminjam = Peminjam::where('kontak', Auth::user()->email)->first();

        if (!$peminjam) {
            return redirect()->route('user.peminjaman.index')
                             ->with('error', 'Akun Anda belum terdaftar sebagai peminjam.');
        }

        $validated = $request->validate([
            'alat_id'        => 'required|exists:alats,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        Peminjaman::create([
            'alat_id'        => $validated['alat_id'],
            'peminjam_id'    => $peminjam->id,
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'status'         => 'dipinjam',
        ]);

        Alat::where('id', $validated['alat_id'])->update(['status' => 'dipinjam']);

        return redirect()->route('user.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        // Pastikan peminjaman ini milik user yang login
        $peminjam = Peminjam::where('kontak', Auth::user()->email)->first();

        if (!$peminjam || $peminjaman->peminjam_id !== $peminjam->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam,
        ]);

        $peminjaman->update([
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'status'          => 'dikembalikan',
        ]);

        $peminjaman->alat->update(['status' => 'tersedia']);

        return redirect()->route('user.peminjaman.index')
                         ->with('success', 'Pengembalian alat berhasil dicatat.');
    }
}