<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Jumlah user
        $jumlahUser = User::count();

        // Jumlah menu
        $jumlahMenu = Menu::count();

        // Jumlah total reservasi
        $jumlahReservasi = Reservasi::count();

        $jumlahMeja = Meja::count();  

        // Jumlah reservasi bulan ini

        return view('pages.admin.dashboard', compact('jumlahUser', 'jumlahMenu', 'jumlahReservasi', 'jumlahMeja'));
    }
}
