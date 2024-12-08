<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the menus.
     */
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
    
        $menus = Menu::with('categories')
            ->when($search, function ($query, $search) {
                return $query->where('nama_menu', 'like', '%' . $search . '%');
            })
            ->when($categoryFilter, function ($query, $categoryFilter) {
                return $query->whereHas('categories', function ($q) use ($categoryFilter) {
                    $q->where('categories.id', $categoryFilter); // Spesifikasikan tabel 'categories'
                });
            })
            ->when($minPrice, function ($query, $minPrice) {
                return $query->where('harga', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                return $query->where('harga', '<=', $maxPrice);
            })
            ->paginate(5); // Paginasi 10 item per halaman
    
        $categories = Category::all(); // Ambil semua kategori untuk filter
    
        return view('pages.admin.menu.index', compact('menus', 'categories', 'search', 'categoryFilter', 'minPrice', 'maxPrice'));
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Simpan gambar di folder public/menu jika ada
        if ($request->hasFile('image')) {
            // Ambil file gambar yang di-upload
            $file = $request->file('image');
            
            // Tentukan nama file dengan timestamp
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Tentukan path penyimpanan
            $path = public_path('storage/menu');
            
            // Pastikan folder sudah ada, jika tidak buat folder baru
            if (!file_exists($path)) {
                mkdir($path, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke direktori yang dituju
            $file->move($path, $filename);

            // Menyimpan path gambar untuk disimpan di database
            $image = 'menu/' . $filename;
        }

        // Menyimpan data menu baru
        $menu = Menu::create([
            'image' => $image,  // Menyimpan path gambar
            'nama_menu' => $validatedData['nama_menu'],
            'harga' => $validatedData['harga'],
            'description' => $validatedData['description'],
        ]);

        // Attach kategori ke menu
        $menu->categories()->attach($validatedData['category_ids']);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

   /**
 * Display the specified menu.
 */
public function show($id)
{
    $menu = Menu::with('categories')->findOrFail($id);
    return view('pages.admin.menu.show', compact('menu'));
}

    /**
     * Show the form for editing the specified menu.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        $selectedCategories = $menu->categories->pluck('id')->toArray();

        return view('pages.admin.menu.edit', compact('menu', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $menu = Menu::findOrFail($id);

        // Update gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::delete('public/menu/' . $menu->image);  // Menghapus gambar lama dari storage
            }

            // Ambil file gambar yang di-upload
            $file = $request->file('image');
            
            // Tentukan nama file dengan timestamp
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Tentukan path penyimpanan
            $path = public_path('storage/menu');
            
            // Pastikan folder sudah ada, jika tidak buat folder baru
            if (!file_exists($path)) {
                mkdir($path, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke direktori yang dituju
            $file->move($path, $filename);

            // Menyimpan path gambar yang baru untuk disimpan di database
            $menu->image = 'menu/' . $filename;
        }

        // Update data menu
        $menu->update([
            'nama_menu' => $validatedData['nama_menu'],
            'harga' => $validatedData['harga'],
            'description' => $validatedData['description'],
        ]);

        // Sync kategori dengan menu
        $menu->categories()->sync($validatedData['category_ids']);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->image) {
            Storage::delete('public/menu/' . $menu->image);  // Menghapus gambar dari storage
        }

        // Detach kategori sebelum menghapus menu
        $menu->categories()->detach();

        // Hapus data menu
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
