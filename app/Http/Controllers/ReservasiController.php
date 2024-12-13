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
public function searchMeja(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'search' => 'nullable|string|max:255'
    ]);

    // Query dengan multiple kondisi pencarian dan pagination
    $meja = Meja::with('location')
        ->where('status', 'tersedia')
        ->where(function($query) use ($validated) {
            $query->where('nomor_meja', 'like', '%' . $validated['search'] . '%')
                  ->orWhereHas('location', function($q) use ($validated) {
                      $q->where('name', 'like', '%' . $validated['search'] . '%');
                  });
        })
        ->paginate(9);

    return response()->json([
        'data' => $meja->items(),
        'current_page' => $meja->currentPage(),
        'total_pages' => $meja->lastPage(),
        'total_items' => $meja->total()
    ]);
}
public function create(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'kapasitas' => 'nullable|integer',
        'location' => 'nullable|string',
        'search_menu' => 'nullable|string',
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

    // Pagination untuk meja dengan parameter query string
    $meja = $query->paginate(9)->appends($request->only(['kapasitas', 'location']));

    // Query untuk menu dengan filtering dan pagination
    $menuQuery = Menu::query();

    // Filtering berdasarkan pencarian menu
    if ($request->filled('search_menu')) {
        $menuQuery->where('nama_menu', 'like', '%' . $validated['search_menu'] . '%')
                  ->orWhere('harga', 'like', '%' . $validated['search_menu'] . '%');
    }

    // Pagination untuk menu
    $menus = $menuQuery->paginate(3)->appends($request->only('search_menu'));

    return view('pages.user.reservasi.create', [
        'meja' => $meja,
        'menus' => $menus,
        'kapasitas' => $request->input('kapasitas'),
        'location' => $request->input('location'),
        'search_menu' => $request->input('search_menu')
    ]);
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
    $query = Menu::with('categories') // Eager load categories
        ->when($request->filled('search'), function ($q) use ($validated) {
            return $q->where(function ($subQuery) use ($validated) {
                $subQuery->where('nama_menu', 'like', '%' . $validated['search'] . '%')
                        ->orWhere('harga', 'like', '%' . $validated['search'] . '%')
                        ->orWhereHas('categories', function ($catQuery) use ($validated) {
                            $catQuery->where('nama_kategori', 'like', '%' . $validated['search'] . '%');
                        });
            });
        });

    // Pagination
    $menu = $query->paginate(6); // 6 item per halaman

    // Transform menu data untuk response
    $transformedMenu = $menu->map(function ($item) {
        return [
            'id' => $item->id,
            'nama_menu' => $item->nama_menu,
            'harga' => $item->harga,
            'image' => $item->image ? asset('storage/' . $item->image) : asset('images/default-menu.jpg'),
            'categories' => $item->categories->pluck('nama_kategori')
        ];
    });

    return response()->json([
        'data' => $transformedMenu,
        'current_page' => $menu->currentPage(),
        'total_pages' => $menu->lastPage(),
        'total_items' => $menu->total()
    ]);
}

public function sortMenu(Request $request)
{
    // Validasi input sort
    $validated = $request->validate([
        'sort_by' => 'in:asc,desc'
    ]);

    // Query sorting menu dengan pagination
    $menu = Menu::orderBy('nama_menu', $validated['sort_by'] ?? 'asc')
        ->paginate(2);

    return response()->json([
        'data' => $menu->items(),
        'current_page' => $menu->currentPage(),
        'total_pages' => $menu->lastPage(),
        'total_items' => $menu->total()
    ]);
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
    // Validasi berdasarkan metode pembayaran
    $request->validate([
        'payment_method' => 'required|in:scan,kartu_kredit,e_wallet',
        'total_price' => 'required|numeric',
    ]);

    $reservasi = Reservasi::findOrFail($id);

    // Validasi tambahan berdasarkan metode pembayaran
    switch ($request->input('payment_method')) {
        case 'e_wallet':
            $request->validate([
                'e_wallet_provider' => 'required|in:ovo,gopay,dana,shopeepay',
                'e_wallet_number' => 'required|string'
            ]);
            $mediaProvider = $request->input('e_wallet_provider');
            $nomorMedia = $request->input('e_wallet_number');
            break;

        case 'kartu_kredit':
            $request->validate([
                'credit_card_type' => 'required|in:visa,mastercard,american_express',
                'credit_card_number' => 'required|numeric|digits_between:12,19'
            ]);
            $mediaProvider = $request->input('credit_card_type');
            $nomorMedia = $request->input('credit_card_number');
            break;

        default:
            $mediaProvider = null;
            $nomorMedia = null;
    }

    // Update reservasi
    $reservasi->update([
        'metode_pembayaran' => $request->input('payment_method'),
        'media_pembayaran' => $mediaProvider,
        'nomor_media' => $nomorMedia,
        'total_bayar' => $request->input('total_price'),
        'status_reservasi' => 'confirmed'
    ]);

    // Proses lanjutan (ubah status meja, dll)
    $mejaIds = $reservasi->meja->pluck('id')->toArray();
    Meja::whereIn('id', $mejaIds)->update(['status' => 'tidak tersedia']);

    return redirect()->route('user.reservasi.nota', $id);
}
    // Di ReservasiController.php
    public function nota($id)
    {
        $reservasi = Reservasi::where('id', $id)->with('menus', 'meja')->first();
        return view('pages.user.reservasi.nota', compact('reservasi'));
    }
    
    public function show($id)
    {
        $menu = menu::with(['ulasans.user', 'categories'])->findOrFail($id);
        return view('pages.user.menu.nota', compact('menu'));
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
