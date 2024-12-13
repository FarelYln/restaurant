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
      $month = $request->input('month', date('m')); // Default ke bulan saat ini jika tidak dipilih
      $reservations = Reservasi::selectRaw('WEEK(tanggal_reservasi, 1) as week, COUNT(*) as count, SUM(total_bayar) as total_pemasukan')
          ->whereMonth('tanggal_reservasi', '=', $month)
          ->groupBy('week')
          ->get();
  
      // Total pemasukan seluruh bulan
      $totalPemasukan = Reservasi::whereMonth('tanggal_reservasi', '=', $month)
          ->sum('total_bayar');
  
      return view('pages.admin.dashboard', compact('reservations', 'month', 'totalPemasukan'));

    }
}
