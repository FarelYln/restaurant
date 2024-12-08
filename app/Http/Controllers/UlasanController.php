<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'id_menu' => 'required|exists:menus,id',
        'rating' => 'required|in:1,2,3,4,5',
        'description' => 'nullable|string',
    ]);

    Ulasan::create([
        'id_user' => Auth::id(), // Mengambil ID pengguna yang sedang login
        'id_menu' => $request->id_menu,
        'rating' => $request->rating,
        'description' => $request->description,
    ]);

    return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan!');
}
}