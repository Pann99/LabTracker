<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjam::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $peminjams = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('peminjam.index', compact('peminjams'));
    }

    public function create()
    {
        return view('peminjam.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:150',
            'nim_nip' => 'required|string|max:50|unique:peminjams,nim_nip',
            'kontak'  => 'nullable|string|max:50',
        ]);

        Peminjam::create($validated);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil ditambahkan.');
    }

    public function edit(Peminjam $peminjam)
    {
        return view('peminjam.edit', compact('peminjam'));
    }

    public function update(Request $request, Peminjam $peminjam)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:150',
            'nim_nip' => 'required|string|max:50|unique:peminjams,nim_nip,' . $peminjam->id,
            'kontak'  => 'nullable|string|max:50',
        ]);

        $peminjam->update($validated);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil diperbarui.');
    }

    public function destroy(Peminjam $peminjam)
    {
        $peminjam->delete();

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil dihapus.');
    }
}