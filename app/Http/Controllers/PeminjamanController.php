<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['alat', 'peminjam'])
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $alats = Alat::where('status', 'tersedia')->get();
        $peminjams = Peminjam::all();

        return view('peminjaman.create', compact('alats', 'peminjams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_id'        => 'required|exists:alats,id',
            'peminjam_id'    => 'required|exists:peminjams,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        Peminjaman::create([
            ...$validated,
            'status' => 'dipinjam',
        ]);

        Alat::where('id', $validated['alat_id'])->update(['status' => 'dipinjam']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam,
        ]);

        $peminjaman->update([
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'status' => 'dikembalikan',
        ]);

        $peminjaman->alat->update(['status' => 'tersedia']);

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian alat tercatat.');
    }
}