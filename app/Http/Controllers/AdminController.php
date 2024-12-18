<?php
namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun yang dipilih dari dropdown, default ke bulan dan tahun saat ini
        $month = $request->input('month', now()->month);
        $selectedYear = $request->input('year', now()->year);
    
        // Validasi input bulan
        if ($month < 1 || $month > 12) {
            return redirect()->back()->withErrors('Bulan tidak valid.');
        }
    
        // Ambil data reservasi per minggu untuk bulan dan tahun yang dipilih
        $reservations = Reservasi::selectRaw("
            CASE
        WHEN DAY(tanggal_reservasi) IN (29, 30, 31) THEN 4
        ELSE FLOOR((DAY(tanggal_reservasi) - 1) / 7) + 1
    END as week,
    COUNT(*) as count,
    SUM(total_bayar) as total_pemasukan
")
        ->whereMonth('tanggal_reservasi', '=', $month)
        ->whereYear('tanggal_reservasi', '=', $selectedYear)
        ->whereIn('status_reservasi', ['confirmed', 'completed']) // Tambahkan filter status
        ->groupBy('week')
        ->get();
    
        // Total pemasukan seluruh bulan
        $totalPemasukan = Reservasi::whereMonth('tanggal_reservasi', '=', $month)
            ->whereYear('tanggal_reservasi', '=', $selectedYear)
            ->whereIn('status_reservasi', ['confirmed', 'completed']) // Tambahkan filter status
            ->sum('total_bayar');
    
        // Pass the data to the view
        return view('pages.admin.dashboard', compact('reservations', 'month', 'totalPemasukan', 'selectedYear'));
    }
}
