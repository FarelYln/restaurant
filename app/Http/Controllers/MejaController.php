<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Location; // Pastikan untuk mengimpor model Location
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function adminIndex(Request $request)
    {

        
        // Mengambil semua data meja dengan fitur pencarian dan pengurutan
        $query = Meja::with('location'); // Mengambil lokasi terkait
        

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
        $locations = Location::all();
        return view('pages.admin.meja.create', compact('locations'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja,nomor_meja',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak tersedia',
            'location_id' => 'required|exists:locations,id', // Validasi lokasi
        ]);
    
        // Buat meja baru dengan data yang valid
        Meja::create([
            'nomor_meja' => $request->nomor_meja,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status, // Status diambil dari input hidden
            'location_id' => $request->location_id, // Menyimpan ID lokasi
        ]);
    
        // Mengubah pesan sukses ke dalam bahasa Indonesia
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $meja = Meja::findOrFail($id);
        $locations = Location::all(); // Ambil semua lokasi untuk dropdown
        return view('pages.admin.meja.edit', compact('meja', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja,nomor_meja,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,tidak tersedia',
            'location_id' => 'required|exists:locations,id', // Validasi lokasi
        ]);

        $meja = Meja::findOrFail($id);
        $meja->update($request->all());
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);
        // Cek status meja sebelum menghapus
        if ($meja->status === 'tidak tersedia') {
            return redirect()->route('admin.meja.index')->with('error', 'Meja tidak dapat dihapus karena tidak tersedia.');
        }
        $meja->delete();
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus.');
    }
}