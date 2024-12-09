<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();
    
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('floor', 'like', '%' . $request->search . '%');
        }
    
        // Pengurutan
        if ($request->has('sort_by') && $request->sort_by != '') {
            $query->orderBy($request->sort_by, $request->sort_order ?? 'asc');
        }
    
        $locations = $query->paginate(2); // Menggunakan pagination
    
        return view('pages.admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('pages.admin.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('locations')->where(function ($query) use ($request) {
                    return $query->where('floor', $request->floor);
                })
            ],
            'floor' => 'required|integer|min:1'
        ], [
            'name.required' => 'Nama lokasi harus diisi.',
            'name.unique' => 'Nama lokasi sudah ada di lantai ini.',
            'floor.required' => 'Lantai harus diisi.',
            'floor.integer' => 'Lantai harus berupa angka.',
            'floor.min' => 'Lantai minimal 1.'
        ]);

        Location::create($validated);

        return redirect()->route('admin.location.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Debugging: Lihat data yang diterima
        // dd($request->all());
    $location = Location::findOrFail($id);
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('locations')
                    ->where(function ($query) use ($request, $location) {
                        return $query->where('floor', $request->floor)
                                     ->where('id', '!=', $location->id);
                    })
            ],
            'floor' => 'required|integer|min:1'
        ], [
            'name.required' => 'Nama lokasi harus diisi.',
            'name.unique' => 'Nama lokasi sudah ada di lantai ini.',
            'floor.required' => 'Lantai harus diisi.',
            'floor.integer' => 'Lantai harus berupa angka.',
            'floor.min' => 'Lantai minimal 1.'
        ]);
    
        // Debugging: Lihat data yang divalidasi
        // dd($validated);
    
        $location = Location::findOrFail($id);
        $location->update($request->all());
    
        // Debugging: Lihat data setelah update
        // dd($location);
    
        return redirect()->route('admin.location.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('pages.admin.locations.edit', compact('location'));
    }



    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.location.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}