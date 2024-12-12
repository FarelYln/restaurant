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
    public function history(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        
        $reservasiData = Reservasi::whereIn('status_reservasi', ['completed'])
                                  ->with('menus', 'meja', 'user') // Mengambil relasi menus, meja, dan user
                                
                                  ->when($search, function ($query, $search) {
                                      $query->where(function ($query) use ($search) {
                                          $query->where('tanggal_reservasi', 'like', '%' . $search . '%')
                                                ->orWhere('status_reservasi', 'like', '%' . $search . '%')
                                                ->orWhereHas('user', function ($query) use ($search) {
                                                    $query->where('name', 'like', '%' . $search . '%');
                                                })
                                                ->orWhereHas('meja', function ($query) use ($search) {
                                                    $query->where('nomor_meja', 'like', '%' . $search . '%');
                                                });
                                      });
                                  })
                                  ->paginate(9); // Menambahkan paginate dengan 10 item per halaman
            
        return view('pages.admin.reservasi.history', compact('reservasiData'));
    }
    public function adminIndex(Request $request)
{
    $status = $request->input('status');
    $search = $request->input('search');
    
    $reservasiData = Reservasi::whereIn('status_reservasi', ['confirmed'])
                              ->with('menus', 'meja', 'user') // Mengambil relasi menus, meja, dan user
                            
                              ->when($search, function ($query, $search) {
                                  $query->where(function ($query) use ($search) {
                                      $query->where('tanggal_reservasi', 'like', '%' . $search . '%')
                                            ->orWhere('status_reservasi', 'like', '%' . $search . '%')
                                            ->orWhereHas('user', function ($query) use ($search) {
                                                $query->where('name', 'like', '%' . $search . '%');
                                            })
                                            ->orWhereHas('meja', function ($query) use ($search) {
                                                $query->where('nomor_meja', 'like', '%' . $search . '%');
                                            });
                                  });
                              })
                              ->paginate(10); // Menambahkan paginate dengan 10 item per halaman
        
    return view('pages.admin.reservasi.index', compact('reservasiData'));
}
    public function index()
    {
        // Ambil reservasi yang memiliki status 'confirmed' atau 'completed' milik user yang sedang login
        $reservasiData = Reservasi::whereIn('status_reservasi', ['confirmed', 'completed'])
                                  ->where('id_user', auth()->user()->id) // Membatasi hanya yang milik user yang sedang login
                                  ->with('menus', 'meja') // Mengambil relasi menus dan meja
                                  ->get();
        
        return view('pages.user.reservasi.index', compact('reservasiData'));
    }
    
    
    
// Controller
public function create(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'kapasitas' => 'nullable|integer',
        'location' => 'nullable|string',
    ]);

    // Query untuk meja dengan eager loading dan filtering
    $query = Meja::with('location')  // Eager loading relasi lokasi
        ->where('status', 'tersedia');

    // Filtering berdasarkan kapasitas
    if ($request->filled('kapasitas')) {
        $query->where('kapasitas', $validated['kapasitas']);
    }

    // Filtering berdasarkan lokasi
    if ($request->filled('location')) {
        $query->whereHas('location', function ($q) use ($validated) {
            $q->where('name', 'like', '%' . $validated['location'] . '%');
        });
    }

    // Pagination dengan parameter query string
    $meja = $query->paginate(6)->appends($request->only(['kapasitas', 'location']));

    // Ambil semua menu
    $menus = Menu::all();

    return view('pages.user.reservasi.create', [
        'meja' => $meja,
        'menus' => $menus,
        'kapasitas' => $request->input('kapasitas'),
        'location' => $request->input('location')
    ]);
}

public function searchMeja(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'search' => 'nullable|string|max:255'
    ]);

    // Query dengan multiple kondisi pencarian
    $meja = Meja::with('location')
        ->where('status', 'tersedia')
        ->where(function($query) use ($validated) {
            $query->where('nomor_meja', 'like', '%' . $validated['search'] . '%')
                  ->orWhereHas('location', function($q) use ($validated) {
                      $q->where('name', 'like', '%' . $validated['search'] . '%');
                  });
        })
        ->get();

    return response()->json($meja);
}

public function sortMeja(Request $request)
{
    // Validasi input sort
    $validated = $request->validate([
        'sort_by' => 'in:asc,desc'
    ]);

    // Query sorting meja
    $meja = Meja::with('location')
        ->where('status', 'tersedia')
        ->orderBy('nomor_meja', $validated['sort_by'] ?? 'asc')
        ->get();

    return response()->json($meja);
}

public function filterMeja(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'kapasitas' => 'nullable|integer',
        'location' => 'nullable|string'
    ]);

    // Query filter meja dengan kondisi dinamis
    $query = Meja::with('location')
        ->where('status', 'tersedia');

    // Filter kapasitas
    if ($request->filled('kapasitas')) {
        $query->where('kapasitas', $validated['kapasitas']);
    }

    // Filter lokasi
    if ($request->filled('location')) {
        $query->whereHas('location', function ($q) use ($validated) {
            $q->where('name', 'like', '%' . $validated['location'] . '%');
        });
    }

    $meja = $query->get();

    return response()->json($meja);
}

public function searchMenu(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'search' => 'nullable|string|max:255'
    ]);

    // Query pencarian menu dengan multiple kondisi
    $menu = Menu::where('nama_menu', 'like', '%' . $validated['search'] . '%')
        ->orWhere('harga', 'like', '%' . $validated['search'] . '%')
        ->get();

    return response()->json($menu);
}

public function sortMenu(Request $request)
{
    // Validasi input sort
    $validated = $request->validate([
        'sort_by' => 'in:asc,desc'
    ]);

    // Query sorting menu
    $menu = Menu::orderBy('nama_menu', $validated['sort_by'] ?? 'asc')
        ->get();

    return response()->json($menu);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required|date_format:H:i',
            'id_meja' => 'required|array|min:1',
            'id_meja.*' => 'exists:meja,id',
            'status_reservasi' => 'required|in:pending,confirmed,completed,canceled',
            'menu' => 'array', 
        ]);
    
        // Validasi khusus untuk menu
        $menuValidation = [];
        
        // Cek apakah ada menu yang diisi
        $hasMenuOrder = false;
        
        if (!empty($request->input('menu'))) {
            foreach ($request->input('menu') as $menuId => $menuData) {
                // Jika jumlah pesanan lebih dari 0
                if (!empty($menuData['jumlah_pesanan']) && $menuData['jumlah_pesanan'] > 0) {
                    $hasMenuOrder = true;
                    
                    // Validasi spesifik untuk menu yang diisi
                    $menuValidation['menu.'.$menuId.'.id'] = 'required|integer|exists:menus,id';
                    $menuValidation['menu.'.$menuId.'.jumlah_pesanan'] = 'required|integer|min:1';
                }
            }
        }
    
        // Jika tidak ada menu yang dipesan
        if (!$hasMenuOrder) {
            return redirect()->back()->withErrors(['menu' => 'Minimal satu menu harus dipilih dengan jumlah pesanan.']);
        }
    
        // Jalankan validasi tambahan jika ada menu yang diisi
        if (!empty($menuValidation)) {
            $request->validate($menuValidation);
        }
    
        // Simpan data reservasi ke database
        $reservasi = Reservasi::create([
            'id_user' => auth()->id(),
            'tanggal_reservasi' => Carbon::parse($validated['tanggal_reservasi'] . ' ' . $validated['jam_reservasi']),
            'status_reservasi' => $validated['status_reservasi'],
        ]);
    
        // Menyimpan data meja ke pivot table
        $reservasi->meja()->attach($validated['id_meja']);
    
        // Simpan menu pesanan
        foreach ($request->input('menu') as $menuId => $menuData) {
            if (!empty($menuData['jumlah_pesanan']) && $menuData['jumlah_pesanan'] > 0) {
                $reservasi->menus()->attach($menuData['id'], ['jumlah_pesanan' => $menuData['jumlah_pesanan']]);
            }
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
    
        // Ubah status meja menjadi tidak tersedia
        $mejaIds = $reservasi->meja->pluck('id')->toArray(); // Ambil ID meja terkait
        Meja::whereIn('id', $mejaIds)->update(['status' => 'tidak tersedia']);
    
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
            return redirect()->route('admin.reservasi.index')->with('success', 'Checkout berhasil dilakukan dan data akan masuk ke history.');
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
