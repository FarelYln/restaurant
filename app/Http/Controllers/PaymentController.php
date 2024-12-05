<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentPage(Reservasi $reservasi)
    {
        // Pastikan reservasi milik user yang sedang login
        if ($reservasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Cek apakah sudah ada pembayaran
        $existingPayment = Payment::where('reservasi_id', $reservasi->id)->first();
        
        if ($existingPayment) {
            return redirect()->route('pages.user.reservasi.index')
                ->with('error', 'Reservasi sudah memiliki pembayaran');
        }

        $paymentMethods = [
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'kartu_kredit' => 'Kartu Kredit'
        ];

        return view('pages.user.reservasi.payment', [
            'reservasi' => $reservasi,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function processPayment(Request $request, Reservasi $reservasi)
    {
        // Pastikan reservasi milik user yang sedang login
        if ($reservasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    
        // Validasi input
        $rules = [
            'payment_method' => 'required|in:transfer_bank,e_wallet,kartu_kredit',
        ];
    
        // Tambahan validasi khusus untuk kartu kredit
        if ($request->payment_method === 'kartu_kredit') {
            $rules += [
                'nomor_kartu' => [
                    'required', 
                    'numeric', 
                    'min:1000000000000000', // Minimal 16 digit
                    'max:9999999999999999999' // Maksimal 19 digit
                ],
                'jumlah_bayar' => [
                    'required', 
                    'numeric', 
                    'min:' . $reservasi->total_harga,
                    'max:' . ($reservasi->total_harga * 2) // Batasi maksimal 2x total harga untuk mencegah kesalahan
                ]
            ];
        }
    
        // Validasi input
        $request->validate($rules, [
            'nomor_kartu.required' => 'Nomor kartu harus diisi.',
            'nomor_kartu.numeric' => 'Nomor kartu harus berupa angka.',
            'nomor_kartu.min' => 'Nomor kartu minimal 16 digit.',
            'nomor_kartu.max' => 'Nomor kartu maksimal 19 digit.',
            'jumlah_bayar.required' => 'Jumlah pembayaran harus diisi.',
            'jumlah_bayar.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah pembayaran minimal sesuai total tagihan.',
            'jumlah_bayar.max' => 'Jumlah pembayaran melebihi batas yang diizinkan.',
        ]);
    
        // Cek apakah sudah ada pembayaran
        $existingPayment = Payment::where('reservasi_id', $reservasi->id)->first();
        
        if ($existingPayment) {
            return redirect()->route('user.reservasi.index')
                ->with('error', 'Reservasi sudah memiliki pembayaran');
        }
    
        // Buat pembayaran baru
        $paymentData = [
            'reservasi_id' => $reservasi->id,
            'payment_method' => $request->payment_method,
            'total_bayar' => $reservasi->total_harga,
            'status' => 'success',
            'nomor_referensi' => 'REF-' . uniqid()
        ];
    
        // Tambahkan nomor kartu jika pembayaran menggunakan kartu kredit
        if ($request->payment_method === 'kartu_kredit') {
            $paymentData['nomor_kartu'] = $request->nomor_kartu;
            
            // Validasi jumlah pembayaran sesuai total tagihan
            if ($request->jumlah_bayar != $reservasi->total_harga) {
                return back()->withErrors([
                    'jumlah_bayar' => 'Jumlah pembayaran harus sesuai dengan total tagihan.'
                ])->withInput();
            }
        }
    
        $payment = Payment::create($paymentData);
    
        // Update status reservasi
        $reservasi->update([
            'status_reservasi' => 'completed'
        ]);
    
        return redirect()->route('user.reservasi.index')
            ->with('success', 'Pembayaran berhasil dilakukan');
    }
}