<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
{
    // Data default untuk index
    return redirect()->route('account.show'); // Redirect ke metode utama
}

    // Method untuk menampilkan semua akun user yang terdaftar
    public function showAccount(Request $request)
    {
        $sort = $request->query('sort', 'name'); // Default ke pengurutan berdasarkan nama

        // Ambil semua data user dan urutkan sesuai pilihan
        $users = User::orderBy($sort, $sort === 'name' ? 'asc' : 'desc')->get();

        // Kirimkan data ke view
        return view('pages.admin.user.index', compact('users', 'sort'));
    }
}
