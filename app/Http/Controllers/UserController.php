<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Method untuk menampilkan akun yang sedang login (user)
    public function index()
    {
        $user = Auth::user(); // Mengambil data user yang login
        $type = 'user'; // Menentukan tipe default user
        return view('pages.admin.user.index', compact('user', 'type'));
    }

    // Method untuk menampilkan akun user atau admin berdasarkan pilihan
    public function showAccount(Request $request, $type = 'user')
    {
        $type = $request->query('type', 'user'); // Default ke 'user'
    $sort = $request->query('sort', 'name'); 

        // Cek apakah pilihan adalah admin
        if ($type == 'admin') {
            // Ambil data admin
            $user = User::where('role', 'admin')->first(); // Mengambil admin pertama dengan role admin
            if (!$user) {
                // Jika tidak ada admin, beri pesan error atau fallback
                return redirect()->route('account.show', ['type' => 'user'])->withErrors('Admin not found.');
            }
        } else {
            // Ambil data user yang sedang login
            $user = Auth::user(); // Mengambil data user yang sedang login
        }

        return view('pages.admin.user.index', compact('user', 'type', 'short')); // Mengirimkan variabel type ke view
    }
}
