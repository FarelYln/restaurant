<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function adminIndex()
    {
        // Mengambil semua data meja
        $meja = Meja::all();
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
            'kapasitas' => 'required|integer|min:1', // Kapasitas minimal 1
            'status' => 'required|in:tersedia,tidak tersedia', // Validasi status meja
        ]);

        // Menyimpan data meja baru, termasuk status
        Meja::create($request->all());

        // Mengarahkan ke halaman index dengan pesan sukses
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Menampilkan form edit dengan data meja yang sesuai
        $meja = Meja::findOrFail($id);
        return view('pages.admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input untuk update
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja,nomor_meja,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak tersedia', // Validasi status meja
        ]);

        $meja = Meja::findOrFail($id); // Menemukan meja berdasarkan ID
        $meja->update($request->all()); // Memperbarui meja

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Menghapus data meja yang dipilih
        $meja = Meja::findOrFail($id);
        $meja->delete();

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus.');
    }
}
