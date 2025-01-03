<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservasiController extends Controller
{
    public function generatePDF($reservasiId)
    {
        $reservasi = Reservasi::findOrFail($reservasiId);
        
        // Hitung total harga
        $totalHarga = $reservasi->menus->sum(function($menu) {
            return $menu->pivot->jumlah_pesanan * $menu->harga;
        });
        
        // Load view PDF dengan layout minimal
        $pdf = PDF::loadView('pdfs.nota', [
            'reservasi' => $reservasi,
            'totalHarga' => $totalHarga
        ])
        // Atur ukuran kertas dan orientasi
        ->setPaper('a4', 'portrait')
        // Hapus margin default
        ->setOption('margin-top', 0)
        ->setOption('margin-right', 0)
        ->setOption('margin-bottom', 0)
        ->setOption('margin-left', 0);
        
        // Generate nama file unik
        $filename = 'Nota_Pembayaran_' . $reservasi->id . '_' . now()->format('YmdHis') . '.pdf';
        
        // Force download
        return $pdf->download($filename);
    }
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
                                  ->with('menus', 'meja.location', 'user') // Menambahkan meja.location
                                  ->when($search, function ($query, $search) {
                                      $query->where(function ($query) use ($search) {
                                          $query->where('tanggal_reservasi', 'like', '%' . $search . '%')
                                                ->orWhere('id_reservasi', 'like', '%' . $search . '%')
                                                ->orWhere('status_reservasi', 'like', '%' . $search . '%')
                                                ->orWhereHas('user', function ($query) use ($search) {
                                                    $query->where('name', 'like', '%' . $search . '%');
                                                })
                                                ->orWhereHas('meja', function ($query) use ($search) {
                                                    $query->where('nomor_meja', 'like', '%' . $search . '%');
                                                })
                                                ->orWhereHas('meja.location', function ($query) use ($search) {
                                                    $query->where('name', 'like', '%' . $search . '%'); // Pencarian berdasarkan nama lokasi
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

    $meja = Meja::with('location')
    ->where('status', 'tersedia')
    ->where(function($query) use ($validated) {
        $query->where('nomor_meja', 'like', '%' . $validated['search'] . '%')
            ->orWhere('kapasitas', 'like', '%' . $validated['search'] . '%') 
            ->orWhereHas('location', function($q) use ($validated) {
                $q->where('name', 'like', '%' . $validated['search'] . '%')
                  ->where('floor', 'like', '%' . $validated['search'] . '%');
            });
    })
    ->get();


    return response()->json($meja);
}

public function create(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'kapasitas' => 'nullable|integer',
        'location' => 'nullable|string',
        'search_menu' => 'nullable|string',
        'sort_price' => 'nullable|in:asc,desc', // Validasi untuk parameter sort_price
    ]);

    // Query untuk meja tanpa pagination
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

    if ($request->filled('floor')) {
        $query->whereHas('location', function ($q) use ($request) {
            $q->where('floor', $request->input('floor'));
        });
    }
    

    // Query untuk meja tanpa pagination
    $meja = $query->get();

    // Query untuk menu dengan filtering tanpa pagination
    $menuQuery = Menu::query();

    // Filtering berdasarkan pencarian menu
    if ($request->filled('search_menu')) {
        $menuQuery->where('nama_menu', 'like', '%' . $validated['search_menu'] . '%')
                  ->orWhere('harga', 'like', '%' . $validated['search_menu'] . '%');
    }

    

    // Menambahkan sorting berdasarkan harga jika parameter sort_price ada
    if ($request->filled('sort_price')) {
        $menuQuery->orderBy('harga', $validated['sort_price']);
    }

    $menus = $menuQuery->get(); // Menggunakan get() untuk mengambil semua data

    return view('pages.user.reservasi.create', [
        'meja' => $meja,
        'menus' => $menus,
        'kapasitas' => $request->input('kapasitas'),
        'location' => $request->input('location'),
        'search_menu' => $request->input('search_menu'),
        'sort_price' => $request->input('sort_price'), // Menambahkan parameter sort_price ke view
    ]);
}




public function sortMeja(Request $request)
{
    // Validasi input sort
    $validated = $request->validate([
        'sort_by' => 'in:asc,desc'
    ]);

    // Query sorting meja tanpa pagination
    $meja = Meja::with('location')
        ->where('status', 'tersedia')
        ->orderBy('nomor_meja', $validated['sort_by'] ?? 'asc')
        ->get(); // Menggunakan get() untuk mengambil semua data

    return response()->json($meja);
}


public function filterMeja(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'kapasitas' => 'nullable|integer',
        'location' => 'nullable|string'
    ]);

    // Query filter meja dengan kondisi dinamis tanpa pagination
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

    $meja = $query->get(); // Menggunakan get() untuk mengambil semua data

    return response()->json($meja);
}


public function searchMenu(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'search' => 'nullable|string|max:255'
    ]);

    // Query pencarian menu dengan multiple kondisi tanpa pagination
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

    // Query tanpa pagination
    $menu = $query->get(); // Menggunakan get() untuk mengambil semua data

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

    return response()->json($transformedMenu);
}


public function sortMenu(Request $request)
{
    // Validasi input sort
    $validated = $request->validate([
        'sort_by' => 'in:asc,desc,price_asc,price_desc'
    ]);

    // Query sorting menu
    $menu = Menu::query();

    if ($validated['sort_by'] === 'price_asc') {
        $menu = $menu->orderBy('harga', 'asc');
    } elseif ($validated['sort_by'] === 'price_desc') {
        $menu = $menu->orderBy('harga', 'desc');
    } else {
        $menu = $menu->orderBy('nama_menu', $validated['sort_by'] ?? 'asc');
    }

    $menu = $menu->get(); // Menggunakan get() untuk mengambil semua data

    return response()->json($menu);
}


public function store(Request $request)
{
    $validated = $request->validate([
        'tanggal_reservasi' => 'required|date|after_or_equal:today',
'jam_reservasi' => [
    'required',
    'date_format:H:i',
    function ($attribute, $value, $fail) {
        // Zona waktu Jakarta
        $timezone = 'Asia/Jakarta';

        // Jam buka dan jam tutup
        $jamBuka = Carbon::createFromTimeString('08:00', $timezone);
        $jamTutup = Carbon::createFromTimeString('22:00', $timezone);

        // Waktu sekarang di zona waktu Jakarta
        $waktuSekarang = Carbon::now($timezone);

        // Mengonversi jam_reservasi menjadi Carbon instance
        $waktuReservasi = Carbon::createFromFormat('H:i', $value, $timezone);

        // Validasi jam reservasi apakah berada di luar jam operasional
        if ($waktuReservasi->lt($jamBuka) || $waktuReservasi->gt($jamTutup)) {
            $fail('Jam reservasi harus antara pukul 08:00 hingga 22:00.');
        }

        // Validasi apakah waktu reservasi minimal 1 jam dari waktu sekarang hanya jika tanggalnya hari ini
        $tanggalReservasi = request()->input('tanggal_reservasi');  // Mendapatkan tanggal dari inputan
        $waktuReservasiTanggal = Carbon::createFromFormat('Y-m-d H:i', $tanggalReservasi . ' ' . $value, $timezone);

        if ($waktuReservasiTanggal->isToday()) {
            // Validasi jika tanggalnya hari ini
            if ($waktuReservasiTanggal->lt($waktuSekarang->copy()->addHour())) {
                $fail('Jam reservasi harus minimal 1 jam dari waktu sekarang.');
            }
        }
    }
],


        'id_meja' => [
            'required', 
            'array', 
            'min:1',
            function ($attribute, $value, $fail) use ($request) {
                $tanggalReservasi = $request->tanggal_reservasi;
                $jamReservasi = $request->jam_reservasi;
                $waktuReservasi = Carbon::parse($tanggalReservasi . ' ' . $jamReservasi);

                foreach ($value as $mejaId) {
                    // Cek apakah ada reservasi yang overlap pada tanggal yang sama
                    $existingReservation = Reservasi::whereHas('meja', function ($query) use ($mejaId) {
                        $query->where('meja.id', $mejaId);
                    })
                    ->whereDate('tanggal_reservasi', $tanggalReservasi)
                    ->whereIn('status_reservasi', ['confirmed'])
                    ->first();

                    if ($existingReservation) {
                        $fail("Meja dengan Nomor $mejaId sudah direservasi pada tanggal " . 
                              Carbon::parse($tanggalReservasi)->format('d-m-Y') . 
                              ". Silakan pilih meja atau tanggal lain.");
                    }
                }
            }
        ],
        'status_reservasi' => 'required|in:pending,confirmed,completed,canceled',
        'menu' => 'array',
    ], [
        'tanggal_reservasi.required' => 'Tanggal reservasi harus diisi.',
        'tanggal_reservasi.date' => 'Tanggal reservasi harus berupa tanggal yang valid.',
        'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh kurang dari hari ini.',
        'jam_reservasi.required' => 'Jam reservasi harus diisi.',
        'jam_reservasi.date_format' => 'Format jam reservasi harus mengikuti H:i.',
        'id_meja.required' => 'Meja yang dipilih harus ada.',
        'id_meja.*.exists' => 'Meja yang dipilih tidak valid.',
        'status_reservasi.required' => 'Status reservasi harus dipilih.',
        'status_reservasi.in' => 'Status reservasi tidak valid.',
        'menu.array' => 'Menu yang dipesan harus dalam format array.',
    ]);
    
    // Validasi khusus untuk menu
    $menuValidation = [];
    $hasMenuOrder = false;
    
    if (!empty($request->input('menu'))) {
        foreach ($request->input('menu') as $menuId => $menuData) {
            if (!empty($menuData['jumlah_pesanan']) && $menuData['jumlah_pesanan'] > 0) {
                $hasMenuOrder = true;
                $menuValidation['menu.'.$menuId.'.id'] = 'required|integer|exists:menus,id';
                $menuValidation['menu.'.$menuId.'.jumlah_pesanan'] = 'required|integer|min:1';
            }
        }
    }

    if (!$hasMenuOrder) {
        return redirect()->back()->withErrors(['menu' => 'Minimal satu menu harus dipilih dengan jumlah pesanan.']);
    }

    if (!empty($menuValidation)) {
        $request->validate($menuValidation, [
            'menu.*.id.required' => 'Menu harus dipilih.',
            'menu.*.id.exists' => 'Menu yang dipilih tidak valid.',
            'menu.*.jumlah_pesanan.required' => 'Jumlah pesanan menu harus diisi.',
            'menu.*.jumlah_pesanan.min' => 'Jumlah pesanan harus lebih dari 0.',
        ]);
    }

    // Simpan data reservasi
    $reservasi = Reservasi::create([
        'id_user' => auth()->id(),
        'tanggal_reservasi' => Carbon::parse($validated['tanggal_reservasi'] . ' ' . $validated['jam_reservasi']),
        'status_reservasi' => $validated['status_reservasi'],
    ]);

    $reservasi->meja()->attach($validated['id_meja']);

    foreach ($request->input('menu') as $menuId => $menuData) {
        if (!empty($menuData['jumlah_pesanan']) && $menuData['jumlah_pesanan'] > 0) {
            $reservasi->menus()->attach($menuData['id'], ['jumlah_pesanan' => $menuData['jumlah_pesanan']]);
        }
    }

    session(['reservasi_id' => $reservasi->id]);
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
        // Validasi request
        $request->validate([
            'payment_method' => 'required|in:scan,kartu_kredit,e_wallet',
            'total_price' => 'required|numeric',
            'payment_option' => 'required|in:full,dp',
        ]);
    
        // Ambil reservasi yang sesuai
        $reservasi = Reservasi::findOrFail($id);
    
        // Menyimpan data kartu kredit atau e-wallet tambahan
        $mediaProvider = null;
        $nomorMedia = null;
        $cardHolderName = null;
    
        switch ($request->input('payment_method')) {
            case 'e_wallet':
                $request->validate([
                    'e_wallet_provider' => 'required|in:ovo,gopay,dana,shopeepay',
                    'e_wallet_number' => 'required|numeric'
                ]);
                $mediaProvider = $request->input('e_wallet_provider');
                $nomorMedia = $request->input('e_wallet_number');
                break;
    
            case 'kartu_kredit':
                $request->validate([
                    'credit_card_type' => 'required|in:visa,mastercard,bca',
                    'card_number' => 'required|numeric|digits_between:12,19',
                    'card_holder_name' => 'required|string|max:255',
                ]);
                $mediaProvider = $request->input('credit_card_type');
                $nomorMedia = $request->input('card_number');
                $cardHolderName = $request->input('card_holder_name');
                break;
        }
    
        // Tentukan total bayar dan status pembayaran berdasarkan opsi pembayaran
        $totalBayar = $request->input('total_price');
        $statusPembayaran = 'lunas';  // Default status
    
        if ($request->input('payment_option') === 'dp') {
            $totalBayar = $totalBayar * 0.1; // Hitung 10% dari total harga
            $statusPembayaran = 'dp';
        }
    
        // Update data reservasi
        $reservasi->update([
            'metode_pembayaran' => $request->input('payment_method'),
            'media_pembayaran' => $mediaProvider,
            'nomor_media' => $nomorMedia,
            'total_bayar' => $totalBayar,
            'status_reservasi' => 'confirmed',
            'status_pembayaran' => $statusPembayaran,  // Tambahkan status pembayaran
            'card_holder_name' => $cardHolderName,
        ]);
    
        // Redirect ke halaman nota
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
    
            // Ubah status reservasi menjadi completed dan status pembayaran menjadi lunas
            $reservasi->update([
                'status_reservasi' => 'completed',
                'status_pembayaran' => 'lunas'
            ]);
    
            DB::commit();
            return redirect()->route('admin.reservasi.index')->with('success', 'Checkout berhasil dilakukan dan data akan masuk ke history.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal melakukan checkout: ' . $e->getMessage());
            return back()->with('error', 'Gagal melakukan checkout. Silakan coba lagi.');
        }
    }

}
