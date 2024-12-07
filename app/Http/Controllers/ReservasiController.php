<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::where('id_user', auth()->id())
            ->with(['meja', 'menus'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Tambahkan remaining time untuk setiap reservasi
        $reservasis->map(function ($reservasi) {
            $reservasi->remaining_time = $this->calculateRemainingTime($reservasi);
            return $reservasi;
        });

        $totalReservasi = Reservasi::count();

        // Reservasi hari ini
        $reservasiHariIni = Reservasi::whereDate('created_at', Carbon::today())->count();

        // Reservasi minggu ini
        $reservasiMingguIni = Reservasi::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->count();

        // Reservasi bulan ini
        $reservasiBulanIni = Reservasi::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return view('pages.user.reservasi.index', compact('reservasis', 'totalReservasi', 'reservasiHariIni', 'reservasiMingguIni', 'reservasiBulanIni'));
    }

    public function create()
    {
        $meja = Meja::where('status', 'tersedia')->get();
        $menus = Menu::all();
        return view('pages.user.reservasi.create', compact('meja', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required|date_format:H:i',
            'id_meja' => 'required|exists:meja,id',
        ]);

        DB::beginTransaction();

        try {
            // Buat reservasi
            $reservasi = Reservasi::create([
                'id_user' => auth()->id(),
                'id_meja' => $request->id_meja,
                'tanggal_reservasi' => Carbon::parse($request->tanggal_reservasi . ' ' . $request->jam_reservasi),
                'status_reservasi' => 'pending',
                'expired_at' => Carbon::now()->addHour(), // Set expired_at otomatis 1 jam setelah reservasi
            ]);

            // Proses menu yang dipesan
            if ($request->has('menu') && is_array($request->menu)) {
                $menuToAttach = [];
                foreach ($request->menu as $menuId => $quantity) {
                    $quantity = intval($quantity);

                    // Hanya tambahkan menu dengan quantity > 0
                    if ($quantity > 0) {
                        $menuToAttach[$menuId] = ['jumlah_pesanan' => $quantity];
                    }
                }

                // Attach semua menu sekaligus
                if (!empty($menuToAttach)) {
                    try {
                        $reservasi->menus()->attach($menuToAttach);
                    } catch (\Exception $menuAttachError) {
                        // Tangkap error spesifik saat attach menu
                        DB::rollBack();
                        return back()->withInput()->with('error', 'Gagal menambahkan menu: ' . $menuAttachError->getMessage());
                    }
                }
            }

            // Update status meja
            $meja = Meja::findOrFail($request->id_meja);
            $meja->update(['status' => 'tidak tersedia']);

            DB::commit();

            return redirect()->route('user.reservasi.index')
                ->with('success', 'Reservasi berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            // Tangkap error dengan pesan detail
            return back()->withInput()->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $menu = Menu::with(['ulasans.user', 'categories'])->findOrFail($id);
        return view('pages.user.menu.show', compact('menu'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $reservasi = Reservasi::findOrFail($id);

            // Update status meja
            $meja = Meja::findOrFail($reservasi->id_meja);
            $meja->update(['status' => 'tersedia']);

            // Hapus relasi menu
            $reservasi->menus()->detach();

            // Hapus reservasi
            $reservasi->delete();

            DB::commit();

            return redirect()->route('user.reservasi.index')
                ->with('success', 'Reservasi berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Batalkan Reservasi Error: ' . $e->getMessage());

            return back()->with('error', 'Gagal membatalkan reservasi');
        }
    }

    public function cancel($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Pastikan hanya pemilik reservasi yang bisa membatalkan
        if ($reservasi->id_user !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk membatalkan reservasi ini.');
        }

        DB::beginTransaction();

        try {
            // Update status reservasi menjadi canceled
            $reservasi->update([
                'status_reservasi' => 'canceled'
            ]);

            // Kembalikan status meja menjadi tersedia
            $meja = Meja::findOrFail($reservasi->id_meja);
            $meja->update(['status' => 'tersedia']);

            // Hapus relasi menu
            $reservasi->menus()->detach();

            DB::commit();

            return redirect()->route('user.reservasi.index')
                ->with('success', 'Reservasi berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pembatalan Reservasi Error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat membatalkan reservasi.');
        }
    }

    public function complete($id)
    {
        // Menyelesaikan reservasi (setelah pembayaran)
        $reservasi = Reservasi::findOrFail($id);

        // Pastikan hanya pemilik reservasi yang bisa menyelesaikan
        if ($reservasi->id_user !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menyelesaikan reservasi ini.');
        }

        // Cek status reservasi
        if ($reservasi->status_reservasi !== 'pending') {
            return back()->with('error', 'Reservasi tidak dapat diselesaikan.');
        }

        DB::beginTransaction();

        try {
            // Update status reservasi menjadi completed
            $reservasi->update([
                'status_reservasi' => 'completed'
            ]);

            // Kembalikan status meja menjadi tersedia
            $meja = Meja::findOrFail($reservasi->id_meja);
            $meja->update(['status' => 'tersedia']);

            DB::commit();

            return redirect()->route('user.reservasi.index')
                ->with('success', 'Reservasi berhasil diselesaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Penyelesaian Reservasi Error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menyelesaikan reservasi.');
        }
    }

    protected function calculateRemainingTime($reservasi)
    {
        $reservasiTime = Carbon::parse($reservasi->tanggal_reservasi);
        $now = Carbon::now();

        // Jika status sudah canceled atau completed, kembalikan status
        if (in_array($reservasi->status_reservasi, ['canceled', 'completed'])) {
            return 'Expired';
        }

        // Cek apakah reservasi sudah melewati waktu expired_at
        if ($now->greaterThan($reservasi->expired_at)) {
            $this->autoCancelReservation($reservasi);
            return 'Expired';
        }

        // Hitung sisa waktu
        $remainingTime = $now->diff($reservasi->expired_at);
        
        return sprintf(
            '%02d:%02d:%02d', 
            $remainingTime->h, 
            $remainingTime->i, 
            $remainingTime->s
        );
    }

    protected function autoCancelReservation($reservasi)
    {
        // Cek apakah reservasi sudah dalam status final
        if (in_array($reservasi->status_reservasi, ['canceled', 'completed'])) {
            return;
        }

        DB::beginTransaction();

        try {
            // Update status reservasi menjadi canceled hanya jika belum final
            $reservasi->update([
                'status_reservasi' => 'canceled'
            ]);

            // Kembalikan status meja menjadi tersedia
            $meja = Meja::findOrFail($reservasi->id_meja);
            $meja->update(['status' => 'tersedia']);

            // Hapus relasi menu
            $reservasi->menus()->detach();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Auto Cancel Reservasi Error: ' . $e->getMessage());
        }
    }

    public function payment($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Pastikan hanya pemilik reservasi yang bisa melihat halaman pembayaran
        if ($reservasi->id_user !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk melihat pembayaran ini.');
        }

        return view('pages.user.reservasi.payment', compact('reservasi'));
    }

    public function getRemainingTime(Reservasi $reservasi)
    {
        // Pastikan reservasi milik user yang sedang login
        if ($reservasi->id_user !== auth()->id()) {
            return response()->json([
                'remaining_time' => 'Expired',
                'status' => 'unauthorized'
            ], 403);
        }

        $remainingTime = $this->calculateRemainingTime($reservasi);
        
        return response()->json([
            'remaining_time' => $remainingTime,
            'status' => $reservasi->status_reservasi
        ]);
    }

    // Tambahkan method untuk mencegah auto-cancel berulang
    public function preventAutoCancel($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Pastikan hanya pemilik reservasi yang bisa
        if ($reservasi->id_user !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cek apakah reservasi masih valid untuk dicegah
        if ($reservasi->status_reservasi === 'pending') {
            return response()->json(['status' => 'valid']);
        }

        return response()->json(['status' => 'invalid']);
    }

    public function chart()
{
    $reservasiPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    if ($reservasiPerBulan->isEmpty()) {
        // Data kosong
        $dataKosong = true;
        $labels = [];
        $data = [];
    } else {
        // Data ada
        $dataKosong = false;
        $labels = $reservasiPerBulan->pluck('bulan')->map(function ($bulan) {
            return date('F', mktime(0, 0, 0, $bulan, 1)); // Nama bulan
        })->toArray();
        $data = $reservasiPerBulan->pluck('jumlah')->toArray();
    }

    return view('pages.admin.dashboard', compact('labels', 'data', 'dataKosong'));
}

}
