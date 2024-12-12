<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
{
    // Ambil bulan yang dipilih dari dropdown, default bulan 1 (Januari)
    $month = $request->input('month', 1);  // Default bulan Januari

    // Ambil data reservasi per minggu untuk bulan yang dipilih
    $reservations = Reservasi::selectRaw('YEAR(tanggal_reservasi) as year, MONTH(tanggal_reservasi) as month, WEEK(tanggal_reservasi) as week, COUNT(*) as count')
        ->whereMonth('tanggal_reservasi', '=', $month)
        ->groupBy('year', 'month', 'week')
        ->orderBy('week')
        ->get();

    // Kirim data ke view, termasuk bulan yang dipilih
    return view('pages.admin.dashboard', compact('reservations', 'month'));
}



}
