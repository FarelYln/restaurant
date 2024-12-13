@extends('layouts.landing_page.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Reservasi</h1>
        <form action="{{ route('user.reservasi.store') }}" method="POST">
            @csrf
            <div class="card mb-4 shadow mt-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Informasi Reservasi</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_reservasi">Tanggal Reservasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" class="form-control @error('tanggal_reservasi') is-invalid @enderror"
                                        name="tanggal_reservasi" value="{{ old('tanggal_reservasi') }}" required>
                                    @error('tanggal_reservasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_reservasi">Jam Reservasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                    <input type="time" class="form-control @error('jam_reservasi') is-invalid @enderror"
                                        name="jam_reservasi" value="{{ old('jam_reservasi') }}" required>
                                    @error('jam_reservasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pilih Meja --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h4>Pilih Meja</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search_meja" class="form-control" placeholder="Cari meja yang dibutuhkan">
                        </div>
                        <div class="col-md-6">
                            <select id="sort_by_meja" class="form-control">
                                <option value="">Urutkan Meja</option>
                                <option value="asc">Nomor Meja (A-Z)</option>
                                <option value="desc">Nomor Meja (Z-A)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Daftar Meja --}}
                    <div id="meja_list" class="row" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($meja as $m)
                            <div class="col-md-4 mb-3 meja-item" data-nomor="{{ $m->nomor_meja }}" data-kapasitas="{{ $m->kapasitas }}" data-lokasi="{{ $m->location->name }}" data-lantai="{{ $m->location->floor }}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="id_meja[]" value="{{ $m->id }}" id="meja-{{ $m->id }}" {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="meja-{{ $m->id }}">
                                                <div>Nomor Meja: {{ $m->nomor_meja }}</div>
                                                <div>Kapasitas: {{ $m->kapasitas }}</div>
                                                <div>Status: <span class="badge {{ $m->status == 'Tersedia' ? 'bg-success' : 'bg-success' }}">{{ $m->status }}</span></div>
                                                <div>Lokasi: {{ $m->location->name }}</div>
                                                <div>Lantai: {{ $m->location->floor }}</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pilih Menu --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h4>Pilih Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search_menu" class="form-control" placeholder="Cari menu...">
                        </div>
                        <div class="col-md-6">
                            <select id="sort_by_menu" class="form-control">
                                <option value="">Urutkan Menu</option>
                                <option value="asc">Nama Menu (A-Z)</option>
                                <option value="desc">Nama Menu (Z-A)</option>
                                <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>Harga Terendah</option>
    <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                            
                        </div>
                    </div>

                    <div class="row" id="menu_list" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($menus as $menu)
                            <div class="col-md-4 mb-4 menu-item" data-nama="{{ $menu->nama_menu }}">
                                <div class="card h-100">
                                    @if ($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->nama_menu }}">
                                    @else
                                        <img src="{{ asset('images/default-menu.jpg') }}" class="card-img-top" alt="Default Image">
                                    @endif
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                                        <p class="card-text">Rp. {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                        <p class="card-text">
                                            <small>Kategori:
                                                @foreach ($menu->categories as $category)
                                                    <span class="badge bg-primary">{{ $category->nama_kategori }}</span>
                                                @endforeach
                                            </small>
                                        </p>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-2 increment-btn" data-target="#menu-quantity-{{ $menu->id }}">+</button>
                                            <input type="number" id="menu-quantity-{{ $menu->id }}" name="menu[{{ $menu->id }}][jumlah_pesanan]" class="form-control form-control-sm text-center w-25" value="{{ old('menu.' . $menu->id . '.jumlah_pesanan', 0) }}" min="0">
                                            <input type="hidden" name="menu[{{ $menu->id }}][id]" value="{{ $menu->id }}">
                                        </div>
                                        @error('menu.' . $menu->id . '.jumlah_pesanan')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('menu')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Hidden Input untuk Status --}}
            <input type="hidden" name="status_reservasi" value="pending">

            {{-- Tombol Submit --}}
            <div class="form-group text-right">
                <button type="submit" class="btn btn-warning text-white">
                    Lanjutkan ke Pembayaran
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Meja Search
            document.getElementById('search_meja').addEventListener('input', function() {
                const mejaSearchValue = this.value.toLowerCase();
                const mejaItems = document.querySelectorAll('.meja-item');
                mejaItems.forEach(item => {
                    const itemName = item.dataset.nomor.toLowerCase() + " " + item.dataset.lokasi.toLowerCase();
                    if (itemName.includes(mejaSearchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Menu Search
            document.getElementById('search_menu').addEventListener('input', function() {
                const menuSearchValue = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    const itemName = item.dataset.nama.toLowerCase();
                    if (itemName.includes(menuSearchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Sorting Meja - menggunakan angka untuk pengurutan
document.getElementById('sort_by_meja').addEventListener('change', function() {
    const sortBy = this.value;
    const mejaItems = Array.from(document.querySelectorAll('.meja-item'));
    mejaItems.sort((a, b) => {
        const nomorA = parseInt(a.dataset.nomor); // Ubah menjadi angka
        const nomorB = parseInt(b.dataset.nomor); // Ubah menjadi angka
        return sortBy === 'asc' ? nomorA - nomorB : nomorB - nomorA; // Urutkan secara numerik
    });
    const mejaList = document.getElementById('meja_list');
    mejaList.innerHTML = '';
    mejaItems.forEach(item => mejaList.appendChild(item));
});

// Sorting Menu
document.getElementById('sort_by_menu').addEventListener('change', function() {
    const sortBy = this.value;
    const menuItems = Array.from(document.querySelectorAll('.menu-item'));

    menuItems.sort((a, b) => {
        if (sortBy === 'asc' || sortBy === 'desc') {
            // Mendapatkan harga dari elemen
            const priceA = parseInt(a.querySelector('.card-text').textContent.replace(/[^\d]/g, '')); // Menghapus karakter selain angka
            const priceB = parseInt(b.querySelector('.card-text').textContent.replace(/[^\d]/g, ''));

            return sortBy === 'asc' ? priceA - priceB : priceB - priceA;
        } else {
            // Sorting berdasarkan nama menu (default)
            const nameA = a.querySelector('.card-title').textContent;
            const nameB = b.querySelector('.card-title').textContent;
            return sortBy === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
        }
    });

    const menuList = document.getElementById('menu_list');
    menuList.innerHTML = '';
    menuItems.forEach(item => menuList.appendChild(item));
});

        });
    </script>
@endpush
