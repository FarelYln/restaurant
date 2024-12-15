<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan kolom pengurutan
        $search = $request->query('search'); // Kata kunci pencarian
        $sort = $request->query('sort', 'name'); // Kolom pengurutan, default ke 'name'

        // Query untuk mendapatkan data user dengan filter pencarian dan pengurutan
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%") // Filter nama
                         ->orWhere('email', 'like', "%$search%"); // Filter email
        })
        ->orderBy($sort, 'asc') // Urutkan berdasarkan kolom yang dipilih
        ->paginate(10); // Batasi 10 data per halaman

        // Kirimkan data ke view, termasuk variabel search dan sort untuk mempertahankan nilai input
        return view('pages.admin.user.index', compact('users', 'search', 'sort'));
    }

    public function showAccount(Request $request)
    {
        // Ambil parameter pencarian dan kolom pengurutan
        $search = $request->query('search'); // Kata kunci pencarian
        $sort = $request->query('sort', 'name'); // Kolom pengurutan, default ke 'name'

        // Query untuk mendapatkan data user dengan filter pencarian dan pengurutan
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%") // Filter nama
                         ->orWhere('email', 'like', "%$search%"); // Filter email
        })
        ->orderBy($sort, 'asc') // Urutkan berdasarkan kolom yang dipilih
        ->paginate(10); // Batasi 10 data per halaman

        // Kirimkan data ke view, termasuk variabel search dan sort untuk mempertahankan nilai input
        return view('pages.admin.user.index', compact('users', 'search', 'sort'));
    }
}
