<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function adminIndex(Request $request)
    {
        // Mengambil semua data meja dengan fitur pencarian dan pengurutan
        $query = Meja::query();

        // Pencarian
        if ($request->has('search')) {
            $query->where('nomor_meja', 'like', '%' . $request->search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $request->search . '%');
        }

        // Pengurutan
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, 'asc');
        }

        $meja = $query->get();
        return view('pages.admin.meja.index', compact('meja'));
    }

    public function create()
    {
        return view('pages.admin.meja.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja,nomor_meja',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak tersedia',
        ]);

        Meja::create($request->all());
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $meja = Meja::findOrFail($id);
        return view('pages.admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja,nomor_meja,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak tersedia',
        ]);

        $meja = Meja::findOrFail($id);
        $meja->update($request->all());
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->delete();
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus.');
    }
}
