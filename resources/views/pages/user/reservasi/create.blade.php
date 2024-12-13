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
                                    <input type="date"
                                        class="form-control @error('tanggal_reservasi') is-invalid @enderror"
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
                            <input type="text" id="search_meja" class="form-control"
                                placeholder="Cari meja yang dibutuhkan">
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
                            <div class="col-md-4 mb-3 meja-item" data-nomor="{{ $m->nomor_meja }}"
                                data-kapasitas="{{ $m->kapasitas }}" data-lokasi="{{ $m->location->name }}"
                                data-lantai="{{ $m->location->floor }}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="id_meja[]"
                                                value="{{ $m->id }}" id="meja-{{ $m->id }}"
                                                {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="meja-{{ $m->id }}">
                                                <div>Nomor Meja: {{ $m->nomor_meja }}</div>
                                                <div>Kapasitas: {{ $m->kapasitas }}</div>
                                                <div>Status: <span
                                                        class="badge {{ $m->status == 'Tersedia' ? 'bg-success' : 'bg-success' }}">{{ $m->status }}</span>
                                                </div>
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

                <!-- Button for Keranjang -->
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <!-- Other content can go here -->

                    <button type="button" class="btn btn-info d-flex align-items-center ms-auto" data-bs-toggle="modal"
                        data-bs-target="#keranjangModal">
                        <i class="bi bi-cart-fill me-2"></i> Keranjang (<span id="keranjangCount">0</span>)
                    </button>
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
                                <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                            </select>

                        </div>
                    </div>

                    <div class="row" id="menu_list" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($menus as $menu)
                            <div class="col-md-4 mb-4 menu-item" data-nama="{{ $menu->nama_menu }}">
                                <div class="card h-100">
                                    @if ($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top"
                                            alt="{{ $menu->nama_menu }}">
                                    @else
                                        <img src="{{ asset('images/default-menu.jpg') }}" class="card-img-top"
                                            alt="Default Image">
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
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm me-2 decrement-btn"
                                                data-target="#menu-quantity-{{ $menu->id }}">-</button>
                                            <input type="number" id="menu-quantity-{{ $menu->id }}"
                                                name="menu[{{ $menu->id }}][jumlah_pesanan]"
                                                class="form-control form-control-sm text-center w-25"
                                                value="{{ old('menu.' . $menu->id . '.jumlah_pesanan', 0) }}"
                                                min="0">
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm me-2 increment-btn"
                                                data-target="#menu-quantity-{{ $menu->id }}">+</button>
                                            <input type="hidden" name="menu[{{ $menu->id }}][id]"
                                                value="{{ $menu->id }}">
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
        <!-- Modal Keranjang -->
<div class="modal fade" id="keranjangModal" tabindex="-1" aria-labelledby="keranjangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Ubah class menjadi modal-lg untuk memperlebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keranjangModalLabel">Keranjang Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="keranjangItems" class="list-group">
                    <!-- Cart items will be dynamically inserted by JavaScript -->
                </ul>
                <div class="mt-3">
                    <strong>Total Harga: Rp. <span id="totalHarga">0</span></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .modal-dialog {
        position: fixed;
        top: 0;
        right: 0;
        width: 600px; /* Lebar modal ditingkatkan */
        height: 100%;
        margin: 0;
        max-width: none;
    }

    .modal-content {
        height: 100%;
        border-radius: 0;
        padding: 20px; /* Menambahkan padding agar lebih rapi */
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        padding: 15px;
        background-color: #f8f9fa; /* Menambahkan latar belakang untuk header modal */
    }

    .modal-body {
        overflow-y: auto;
        height: calc(100% - 160px); /* Menyesuaikan tinggi modal setelah header dan footer */
    }

    .modal-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        border-top: 1px solid #dee2e6;
        padding: 10px;
        background-color: #f8f9fa; /* Menambahkan latar belakang untuk footer modal */
    }

    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px; /* Menambahkan padding agar lebih luas */
        border: 1px solid #dee2e6; /* Memberikan batas pada item keranjang */
        margin-bottom: 10px; /* Memberikan jarak antar item */
    }

    .list-group-item img {
        width: 70px; /* Mengatur ukuran gambar */
        height: 70px;
        object-fit: cover;
    }

    .list-group-item .d-flex {
        align-items: center;
    }

    .list-group-item .d-flex div {
        margin-right: 10px;
    }

    .modal-body strong {
        font-size: 1.2em;
        margin-top: 20px;
    }

    .btn-close {
        font-size: 1.5rem;
    }

    /* Styling tombol tambah / kurangi */
    .cart-decrement-btn, .cart-increment-btn {
        padding: 5px 10px;
    }
</style>


        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const keranjang = {};
            const keranjangCountElement = document.getElementById('keranjangCount');
            const keranjangItemsElement = document.getElementById('keranjangItems');
            const totalHargaElement = document.getElementById('totalHarga');

            function updateKeranjang() {
                keranjangItemsElement.innerHTML = '';
                let totalHarga = 0;
                let totalItems = 0;

                Object.keys(keranjang).forEach(id => {
                    const item = keranjang[id];
                    if (item.jumlah > 0) {
                        totalHarga += item.harga * item.jumlah;
                        totalItems += item.jumlah;

                        const itemHtml = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="${item.image}" alt="${item.nama}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <strong>${item.nama}</strong>
                                <div>Rp. ${item.harga.toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-danger btn-sm me-2 cart-decrement-btn" data-id="${item.id}">-</button>
                            <span class="mx-2">${item.jumlah}</span>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2 cart-increment-btn" data-id="${item.id}">+</button>
                        </div>
                        <div>
                            <strong>Rp. ${(item.harga * item.jumlah).toLocaleString('id-ID')}</strong>
                        </div>
                    </li>
                `;
                        keranjangItemsElement.insertAdjacentHTML('beforeend', itemHtml);
                    }
                });

                totalHargaElement.textContent = totalHarga.toLocaleString('id-ID');
                keranjangCountElement.textContent = totalItems;

                // Add event listeners for cart increment/decrement buttons
                document.querySelectorAll('.cart-increment-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const menuId = this.dataset.id;
                        incrementItemInCart(menuId);
                    });
                });

                document.querySelectorAll('.cart-decrement-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const menuId = this.dataset.id;
                        decrementItemInCart(menuId);
                    });
                });
            }

            function incrementItemInCart(menuId) {
                const input = document.getElementById(`menu-quantity-${menuId}`);
                let jumlah = parseInt(input.value) + 1;
                input.value = jumlah;

                // Ambil informasi menu dari card
                const menuCard = document.querySelector(`.menu-item[data-id="${menuId}"]`);
                const menuItem = {
                    id: menuId,
                    nama: menuCard.querySelector('.card-title').textContent,
                    harga: parseInt(menuCard.querySelector('.card-text').textContent.replace(/[^\d]/g, '')),
                    jumlah: jumlah,
                    image: menuCard.querySelector('.card-img-top').src
                };
                keranjang[menuId] = menuItem;
                updateKeranjang();
            }

            function decrementItemInCart(menuId) {
                const input = document.getElementById(`menu-quantity-${menuId}`);
                let jumlah = Math.max(0, parseInt(input.value) - 1);
                input.value = jumlah;

                if (jumlah > 0) {
                    // Ambil informasi menu dari card
                    const menuCard = document.querySelector(`.menu-item[data-id="${menuId}"]`);
                    const menuItem = {
                        id: menuId,
                        nama: menuCard.querySelector('.card-title').textContent,
                        harga: parseInt(menuCard.querySelector('.card-text').textContent.replace(/[^\d]/g, '')),
                        jumlah: jumlah,
                        image: menuCard.querySelector('.card-img-top').src
                    };
                    keranjang[menuId] = menuItem;
                } else {
                    delete keranjang[menuId];
                }
                updateKeranjang();
            }

            // Add data-id to menu items for easier selection
            document.querySelectorAll('.menu-item').forEach(item => {
                const menuId = item.querySelector('input[type="number"]').id.split('-')[2];
                item.setAttribute('data-id', menuId);
            });

            // Increment and Decrement buttons on menu items
            document.querySelectorAll('.increment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.dataset.target.split('-')[2];
                    incrementItemInCart(menuId);
                });
            });

            document.querySelectorAll('.decrement-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.dataset.target.split('-')[2];
                    decrementItemInCart(menuId);
                });
            });

            // Initial setup for number inputs
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('change', function() {
                    const menuId = this.name.match(/\d+/)[0];
                    const jumlah = parseInt(this.value);

                    if (jumlah < 0) {
                        this.value = 0;
                    }

                    if (jumlah > 0) {
                        // Ambil informasi menu dari card
                        const menuCard = this.closest('.menu-item');
                        const menuItem = {
                            id: menuId,
                            nama: menuCard.querySelector('.card-title').textContent,
                            harga: parseInt(menuCard.querySelector('.card-text').textContent
                                .replace(/[^\d]/g, '')),
                            jumlah: jumlah,
                            image: menuCard.querySelector('.card-img-top').src
                        };
                        keranjang[menuId] = menuItem;
                    } else {
                        delete keranjang[menuId];
                    }

                    updateKeranjang();
                });
            });

            // Search and Sorting functions (keeping the previous implementation)
            document.getElementById('search_meja').addEventListener('input', function() {
                const mejaSearchValue = this.value.toLowerCase();
                const mejaItems = document.querySelectorAll('.meja-item');
                mejaItems.forEach(item => {
                    const itemName = item.dataset.nomor.toLowerCase() + " " + item.dataset.lokasi
                        .toLowerCase();
                    if (itemName.includes(mejaSearchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

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

            // Sorting functions
            document.getElementById('sort_by_meja').addEventListener('change', function() {
                const sortBy = this.value;
                const mejaItems = Array.from(document.querySelectorAll('.meja-item'));
                mejaItems.sort((a, b) => {
                    const nomorA = parseInt(a.dataset.nomor);
                    const nomorB = parseInt(b.dataset.nomor);
                    return sortBy === 'asc' ? nomorA - nomorB : nomorB - nomorA;
                });
                const mejaList = document.getElementById('meja_list');
                mejaList.innerHTML = '';
                mejaItems.forEach(item => mejaList.appendChild(item));
            });

            document.getElementById('sort_by_menu').addEventListener('change', function() {
                const sortBy = this.value;
                const menuItems = Array.from(document.querySelectorAll('.menu-item'));

                menuItems.sort((a, b) => {
                    if (sortBy === 'asc' || sortBy === 'desc') {
                        const priceA = parseInt(a.querySelector('.card-text').textContent.replace(
                            /[^\d]/g, ''));
                        const priceB = parseInt(b.querySelector('.card-text').textContent.replace(
                            /[^\d]/g, ''));

                        return sortBy === 'asc' ? priceA - priceB : priceB - priceA;
                    } else {
                        const nameA = a.querySelector('.card-title').textContent;
                        const nameB = b.querySelector('.card-title').textContent;
                        return sortBy === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(
                            nameA);
                    }
                });

                const menuList = document.getElementById('menu_list');
                menuList.innerHTML = '';
                menuItems.forEach(item => menuList.appendChild(item));
            });
        });
    </script>
@endpush
