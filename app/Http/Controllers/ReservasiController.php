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
    public function index(Request $request)
    {
        // Input untuk filter
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
    
        // Ambil data reservasi dengan filter
        $reservasis = Reservasi::where('id_user', auth()->id())
            ->with(['meja', 'menus'])
            ->when($minPrice, function ($query, $minPrice) {
                return $query->whereHas('menus', function ($q) use ($minPrice) {
                    $q->where('harga', '>=', $minPrice); // Filter harga minimal
                });
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                return $query->whereHas('menus', function ($q) use ($maxPrice) {
                    $q->where('harga', '<=', $maxPrice); // Filter harga maksimal
                });
            })
            ->latest()
            ->paginate(6);
    
        // Statistik reservasi
        $totalReservasi = Reservasi::where('id_user', auth()->id())->count();
        $reservasiHariIni = Reservasi::where('id_user', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->count();
        $reservasiMingguIni = Reservasi::where('id_user', auth()->id())
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        $reservasiBulanIni = Reservasi::where('id_user', auth()->id())
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    
        // Return view dengan data
        return view('pages.user.reservasi.index', compact(
            'reservasis',
            'totalReservasi',
            'reservasiHariIni',
            'reservasiMingguIni',
            'reservasiBulanIni'
        ));
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
            'menu' => 'required|array|min:1',
            'menu.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $reservasi = Reservasi::create([
                'id_user' => auth()->id(),
                'tanggal_reservasi' => Carbon::parse($validated['tanggal_reservasi'] . ' ' . $validated['jam_reservasi']),
                'status_reservasi' => 'pending',
            ]);

            // Proses menu yang dipesan
            $menuToAttach = collect($validated['menu'])
                ->filter(fn($quantity) => $quantity > 0)
                ->mapWithKeys(fn($quantity, $menuId) => [$menuId => ['jumlah_pesanan' => $quantity]]);

            if ($menuToAttach->isNotEmpty()) {
                $reservasi->menus()->attach($menuToAttach);
            }

            // Update status meja dan attach ke reservasi
            Meja::whereIn('id', $validated['id_meja'])->update(['status' => 'tidak tersedia']);
            $reservasi->meja()->attach($validated['id_meja']);

            DB::commit();
            return redirect()->route('user.reservasi.index')->with('success', 'Reservasi berhasil dibuat. Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat reservasi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat reservasi. Silakan coba lagi.');
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

    public function payment($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->id_user !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk melihat pembayaran ini.');
        }

        return view('pages.user.reservasi.payment', compact('reservasi'));
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
