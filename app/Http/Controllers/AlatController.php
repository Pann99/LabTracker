<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        // Filter berdasarkan status (syarat wajib: bisa disaring)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting berdasarkan kolom (syarat wajib: bisa diurutkan)
        $sortable = ['nama_alat', 'kategori', 'status', 'created_at'];
        $sortBy = in_array($request->sort, $sortable) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $alats = $query->orderBy($sortBy, $direction)->paginate(10)->withQueryString();

        return view('alat.index', compact('alats'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_alat'  => 'required|string|max:50|unique:alats,kode_alat',
            'nama_alat'  => 'required|string|max:150',
            'kategori'   => 'required|string|max:100',
            'status'     => 'required|in:tersedia,dipinjam,rusak',
        ]);

        Alat::create($validated);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kode_alat'  => 'required|string|max:50|unique:alats,kode_alat,' . $alat->id,
            'nama_alat'  => 'required|string|max:150',
            'kategori'   => 'required|string|max:100',
            'status'     => 'required|in:tersedia,dipinjam,rusak',
        ]);

        $alat->update($validated);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}