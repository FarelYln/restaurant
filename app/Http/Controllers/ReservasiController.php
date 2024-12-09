<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservasiController extends Controller
{
    public function index()
    {
        // Ambil reservasi yang memiliki status 'confirmed' atau 'completed' milik user yang sedang login
        $reservasiData = Reservasi::whereIn('status_reservasi', ['confirmed', 'completed'])
                                  ->where('id_user', auth()->user()->id) // Membatasi hanya yang milik user yang sedang login
                                  ->with('menus', 'meja') // Mengambil relasi menus dan meja
                                  ->get();
        
        return view('pages.user.reservasi.index', compact('reservasiData'));
    }
    
    
    

    public function create()
    {
        $meja = Meja::where('status', 'tersedia')->paginate(6);
        $menus = Menu::all();
        return view('pages.user.reservasi.create', compact('meja', 'menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required|date_format:H:i',
            'id_meja' => 'required|array|min:1',
            'id_meja.*' => 'exists:meja,id',
            'status_reservasi' => 'required|in:pending,confirmed,completed,canceled',
            'menu' => 'required|array|min:1',
            'menu.*.id' => 'required|integer|exists:menus,id',
            'menu.*.jumlah_pesanan' => 'required|integer|min:1',
        ]);
    
        // Simpan data reservasi ke database
        $reservasi = Reservasi::create([
            'id_user' => auth()->id(),
            'tanggal_reservasi' => Carbon::parse($validated['tanggal_reservasi'] . ' ' . $validated['jam_reservasi']),
            'status_reservasi' => $validated['status_reservasi'],
        ]);
    
        // Menyimpan data meja ke pivot table dan mengubah status meja menjadi 'tidak tersedia'
        $mejaIds = $validated['id_meja']; // Mendapatkan ID meja yang dipilih
        $reservasi->meja()->attach($mejaIds);
    
        // Ubah status meja menjadi tidak tersedia
        Meja::whereIn('id', $mejaIds)->update(['status' => 'tidak tersedia']);
    
        // Simpan menu pesanan
        foreach ($validated['menu'] as $menu) {
            $reservasi->menus()->attach($menu['id'], ['jumlah_pesanan' => $menu['jumlah_pesanan']]);
        }
    
        // Simpan ID reservasi ke session
        session(['reservasi_id' => $reservasi->id]);
    
        // Arahkan ke halaman pembayaran dengan ID reservasi
        return redirect()->route('user.reservasi.payment', ['id' => $reservasi->id]);
    }
    
    public function payment($id)
    {
        // Ambil data reservasi berdasarkan ID yang diteruskan
        $reservasiData = Reservasi::with('menus')->find($id);
    
        if (!$reservasiData) {
            return redirect()->route('user.reservasi.create')->withErrors('Reservasi tidak ditemukan.');
        }
    
        // Hitung total harga
        $totalPrice = $reservasiData->menus->sum(function ($menu) {
            return $menu->pivot->jumlah_pesanan * $menu->harga;
        });
    
        // Menampilkan halaman pembayaran dengan data reservasi dan total harga
        return view('pages.user.reservasi.payment', compact('reservasiData', 'totalPrice'));
    }
    
    
    public function confirmPayment($id, Request $request)
    {
        // Ambil data reservasi berdasarkan ID
        $reservasi = Reservasi::find($id);
    
        if (!$reservasi) {
            return redirect()->route('user.reservasi.create')->withErrors('Reservasi tidak ditemukan.');
        }
    
        // Perbarui status reservasi menjadi confirmed
        $reservasi->status_reservasi = 'confirmed';
        $reservasi->save();
    
        // Lakukan sesuatu jika perlu, seperti mengurangi stok menu atau lainnya
    
        return redirect()->route('user.reservasi.index', ['id' => $id])->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
    
    
    public function show($id)
    {
        $menu = menu::with(['ulasans.user', 'categories'])->findOrFail($id);
        return view('pages.user.menu.show', compact('menu'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $reservasi = Reservasi::findOrFail($id);

            foreach ($reservasi->meja as $meja) {
                $meja->update(['status' => 'tersedia']);
            }

            $reservasi->menus()->detach();
            $reservasi->delete();

            DB::commit();
            return redirect()->route('user.reservasi.index')->with('success', 'Reservasi berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membatalkan reservasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan reservasi. Silakan coba lagi.');
        }
    }



    public function checkout($id)
{
    DB::beginTransaction();

    try {
        $reservasi = Reservasi::findOrFail($id);

        // Pastikan reservasi sudah dalam status confirmed
        if ($reservasi->status_reservasi !== 'confirmed') {
            return back()->with('error', 'Reservasi tidak dalam status yang dapat di-checkout.');
        }

        // Ubah status reservasi menjadi completed
        $reservasi->update(['status_reservasi' => 'completed']);

        // Kembalikan status meja menjadi tersedia
        foreach ($reservasi->meja as $meja) {
            $meja->update(['status' => 'tersedia']);
        }

        DB::commit();
        return redirect()->route('user.reservasi.index')->with('success', 'Checkout berhasil dilakukan.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal melakukan checkout: ' . $e->getMessage());
        return back()->with('error', 'Gagal melakukan checkout. Silakan coba lagi.');
    }
}
    public function chart()
    {
        $reservasiPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = $reservasiPerBulan->pluck('bulan')
            ->map(fn($bulan) => date('F', mktime(0, 0, 0, $bulan, 1)))
            ->toArray();

        $data = $reservasiPerBulan->pluck('jumlah')->toArray();

        return view('pages.admin.dashboard', compact('labels', 'data'));
    }
}
