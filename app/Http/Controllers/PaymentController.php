<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        $reservasiData = session('reservasi_data');

        if (!$reservasiData) {
            return redirect()->route('user.reservasi.create')->with('error', 'Data reservasi tidak ditemukan.');
        }

        return view('pages.user.reservasi.payment', [
            'reservasiData' => $reservasiData,
        ]);
    }

    public function processPayment(Request $request)
    {
        $reservasiData = session('reservasi_data');

        if (!$reservasiData) {
            return redirect()->route('user.reservasi.create')->with('error', 'Data reservasi tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            // Simpan reservasi ke database
            $reservasi = Reservasi::create([
                'id_user' => $reservasiData['id_user'],
                'tanggal_reservasi' => $reservasiData['tanggal_reservasi'],
                'status_reservasi' => 'confirmed', // Status awal setelah pembayaran
            ]);

            // Proses menu yang dipesan
            $menuToAttach = collect($reservasiData['menu'])
                ->filter(fn($quantity) => $quantity > 0)
                ->mapWithKeys(fn($quantity, $menuId) => [$menuId => ['jumlah_pesanan' => $quantity]]);

            if ($menuToAttach->isNotEmpty()) {
                $reservasi->menus()->attach($menuToAttach);
            }

            // Update status meja dan attach ke reservasi
            Meja::whereIn('id', $reservasiData['id_meja'])->update(['status' => 'tidak tersedia']);
            $reservasi->meja()->attach($reservasiData['id_meja']);

            // Hapus data reservasi dari session
            session()->forget('reservasi_data');

            DB::commit();
            return redirect()->route('user .reservasi.index')->with('success', 'Reservasi berhasil dibuat dan pembayaran diterima.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memproses pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }
}