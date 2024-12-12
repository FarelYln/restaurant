<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function landing(Request $request) {
        // Ambil semua kategori
        $categories = Category::all();
        
        // Ambil data menu beserta kategori dan rating rata-rata
        $menus = Menu::with(['categories', 'ulasans'])
            ->get()
            ->map(function ($menu) {
                // Menghitung rata-rata rating untuk setiap menu
                $menu->averageRating = $menu->ulasans->avg('rating');
                return $menu;
            })
            ->sortByDesc('averageRating') // Urutkan berdasarkan rating tertinggi
            ->take(4); // Ambil hanya 4 menu dengan rating terbaik
    
        return view('welcome', compact('menus', 'categories'));
    }
    
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // Ambil semua kategori
        $categories = Category::all();

        // Query untuk menampilkan menu
        $menus = Menu::with('categories')
            ->when($search, function ($query, $search) {
                return $query->where('nama_menu', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                });
            })
            ->paginate(10); // Paginasi 10 item per halaman

        return view('pages.user.menu.index', compact('menus', 'categories'));
    }

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
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
            ->paginate(6); // Paginasi 6 item per halaman

        $categories = Category::all(); // Ambil semua kategori untuk filter

        return view('pages.admin.menu.index', compact('menus', 'categories', 'search', 'categoryFilter', 'minPrice', 'maxPrice'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('storage/menu');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $filename);
            $image = 'menu/' . $filename;
        }

        $menu = Menu::create([
            'image' => $image,
            'nama_menu' => $validatedData['nama_menu'],
            'harga' => $validatedData['harga'],
            'description' => $validatedData['description'],
        ]);

        $menu->categories()->attach($validatedData['category_ids']);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified menu.
     */
    public function show($id)
    {
        // Memuat menu beserta kategori dan ulasan (termasuk pengguna yang memberikan ulasan)
        $menu = Menu::with(['categories', 'ulasans.user'])->findOrFail($id);

        // Menghitung rata-rata rating
        $averageRating = $menu->ulasans->avg('rating');

        return view('pages.admin.menu.show', compact('menu', 'averageRating'));
    }
    public function usershow($id)
    {
        $menu = Menu::with(['categories', 'ulasans.user'])->findOrFail($id);
        $averageRating = $menu->ulasans->avg('rating');

        // Pastikan Anda mengembalikan tampilan pengguna
        return view('pages.user.menu.show', compact('menu', 'averageRating'));
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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete('public/menu/' . $menu->image);
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('storage/menu');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $filename);
            $menu->image = 'menu/' . $filename;
        }

        $menu->update([
            'nama_menu' => $validatedData['nama_menu'],
            'harga' => $validatedData['harga'],
            'description' => $validatedData['description'],
        ]);

        $menu->categories()->sync($validatedData['category_ids']);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::delete('public/menu/' . $menu->image);
        }

        $menu->categories()->detach();
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
