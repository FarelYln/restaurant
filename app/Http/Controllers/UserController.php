<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Menentukan kolom untuk pengurutan, default ke 'name'
        $sort = $request->query('sort', 'name'); // Jika tidak ada query 'sort', default ke 'name'

        // Ambil semua data user dan urutkan sesuai pilihan
        $users = User::orderBy($sort, $sort === 'name' ? 'asc' : 'desc')->get();

        // Kirimkan data ke view, termasuk variabel 'sort' untuk mempertahankan pilihan pengurutan
        return view('pages.admin.user.index', compact('users', 'sort'));
    }

    // Method untuk menampilkan akun pengguna yang sedang login
    public function showAccount(Request $request)
    {
        // Menentukan kolom untuk pengurutan, default ke 'name'
        $sort = $request->query('sort', 'name'); // Jika tidak ada query 'sort', default ke 'name'

        // Ambil semua data user dan urutkan sesuai pilihan
        $users = User::orderBy($sort, $sort === 'name' ? 'asc' : 'desc')->get();

        // Kirimkan data ke view, termasuk variabel 'sort' untuk mempertahankan pilihan pengurutan
        return view('pages.admin.user.index', compact('users', 'sort'));
    }
}
