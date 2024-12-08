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
        // Validasi dasar
        $request->validate([
            'payment_method' => 'required|in:transfer_bank,e_wallet,kartu_kredit',
            'total_bayar' => 'required|numeric|min:' . $reservasi->total_harga
        ]);

        // Cek pembayaran yang sudah ada
        $existingPayment = Payment::where('reservasi_id', $reservasi->id)->first();
        if ($existingPayment) {
            return redirect()->route('user.reservasi.index')
                ->with('error', 'Reservasi sudah memiliki pembayaran');
        }

        // Buat pembayaran
        $payment = Payment::create([
            'reservasi_id' => $reservasi->id,
            'payment_method' => $request->payment_method,
            'total_bayar' => $request->total_bayar,
            'status' => 'success',
            'nomor_referensi' => 'REF-' . uniqid()
        ]);

        // Update status reservasi
        $reservasi->update([
            'status_reservasi' => 'completed'
        ]);

        // Redirect ke halaman nota
        return redirect()->route('payment.nota', $payment->id);
    }

    public function showNota(Payment $payment)
    {
        // Pastikan pembayaran milik user yang sedang login
        if ($payment->reservasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('pages.user.reservasi.nota', [
            'payment' => $payment,
            'reservasi' => $payment->reservasi
        ]);
    }

    public function cetakNota(Payment $payment)
    {
        // Pastikan pembayaran milik user yang sedang login
        if ($payment->reservasi->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Anda bisa menggunakan library PDF seperti FPDF atau Laravel Dompdf
        // Contoh sederhana menggunakan view
        return view('pages.user.reservasi.nota_cetak', [
            'payment' => $payment,
            'reservasi' => $payment->reservasi
        ]);
    }
}