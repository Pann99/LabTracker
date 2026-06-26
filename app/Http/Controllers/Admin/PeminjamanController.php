<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['alat', 'peminjam']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortable  = ['tanggal_pinjam', 'tanggal_kembali'];
        $sortBy    = in_array($request->sort, $sortable) ? $request->sort : 'tanggal_pinjam';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $peminjaman = $query->orderBy($sortBy, $direction)
                            ->paginate(10)
                            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->alat->update(['status' => 'tersedia']);
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}