<?php
namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan yang dipilih dari dropdown, default ke bulan saat ini
        $month = $request->input('month', now()->month);

        // Validasi input bulan
        if ($month < 1 || $month > 12) {
            return redirect()->back()->withErrors('Bulan tidak valid.');
        }

        // Ambil data reservasi per minggu untuk bulan yang dipilih
      // Controller
$reservations = Reservasi::selectRaw('YEAR(tanggal_reservasi) as year, MONTH(tanggal_reservasi) as month, WEEK(tanggal_reservasi) as week, COUNT(*) as count')
->whereMonth('tanggal_reservasi', '=', $month)
->groupBy('year', 'month', 'week')
->orderBy('week')
->get();

// Pemetaan minggu
$reservations->transform(function ($item) {
    $item->week = $item->week + 1; // Geser semua minggu ke nilai berikutnya
    return $item;
});

return view('pages.admin.dashboard', compact('reservations', 'month'));

    }
}
