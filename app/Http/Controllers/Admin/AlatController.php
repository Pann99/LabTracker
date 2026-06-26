<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortable  = ['nama_alat', 'kategori', 'status', 'created_at'];
        $sortBy    = in_array($request->sort, $sortable) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $alats = $query->orderBy($sortBy, $direction)->paginate(10)->withQueryString();

        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        return view('admin.alat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_alat' => 'required|string|max:50|unique:alats,kode_alat',
            'nama_alat' => 'required|string|max:150',
            'kategori'  => 'required|string|max:100',
            'status'    => 'required|in:tersedia,dipinjam,rusak',
        ]);

        Alat::create($validated);

        return redirect()->route('admin.alat.index')
                         ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        return view('admin.alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kode_alat' => 'required|string|max:50|unique:alats,kode_alat,' . $alat->id,
            'nama_alat' => 'required|string|max:150',
            'kategori'  => 'required|string|max:100',
            'status'    => 'required|in:tersedia,dipinjam,rusak',
        ]);

        $alat->update($validated);

        return redirect()->route('admin.alat.index')
                         ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();

        return redirect()->route('admin.alat.index')
                         ->with('success', 'Alat berhasil dihapus.');
    }
}