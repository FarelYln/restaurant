@extends('layouts.landing_page.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Reservasi</h1>
        <form action="{{ route('user.reservasi.store') }}" method="POST">
            @csrf
            <div class="card mb-4 shadow mt-5"> <!-- Menambahkan margin-top hanya pada card ini -->
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
                    <div class="row">
                        {{-- Filter dan Search Meja --}}
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="search_meja" class="form-control"
                                        placeholder="Cari meja (nomor/lokasi)...">
                                </div>
                                <div class="col-md-6">
                                    <select id="sort_by_meja" class="form-control">
                                        <option value="">Urutkan Meja</option>
                                        <option value="asc">Nomor Meja (A-Z)</option>
                                        <option value="desc">Nomor Meja (Z-A)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar Meja --}}
                        <div id="meja_list" class="col-md-12">
                            <div class="row">
                                @foreach ($meja as $m)
                                    <div class="col-md-4 mb-3 meja-item" data-nomor="{{ $m->nomor_meja }}"
                                        data-lokasi="{{ $m->location->name }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="id_meja[]"
                                                        value="{{ $m->id }}" id="meja-{{ $m->id }}"
                                                        {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="meja-{{ $m->id }}">
                                                        Meja {{ $m->nomor_meja }}
                                                        ({{ $m->location->name }})
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination Links --}}
                            <div class="d-flex justify-content-center">
                                {{ $meja->links('pagination::bootstrap-4') }}
                            </div>
                            @error('id_meja')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            {{-- Pilih Menu --}}
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h4>Pilih Menu</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <input type="text" id="search_menu" class="form-control"
                                                placeholder="Cari menu...">
                                        </div>
                                        <div class="col-md-6">
                                            <select id="sort_by_menu" class="form-control">
                                                <option value="">Urutkan Menu</option>
                                                <option value="asc">Nama Menu (A-Z)</option>
                                                <option value="desc">Nama Menu (Z-A)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="menu_list">
                                        @foreach ($menus as $menu)
                                            <div class="menu-item mb-3" data-nama="{{ $menu->nama_menu }}"
                                                data-harga="{{ $menu->harga }}">
                                                <div class="d-flex align-items-center">
                                                    <label class="mr-3 flex-grow-1">
                                                        {{ $menu->nama_menu }}
                                                        (Rp. {{ number_format($menu->harga, 0, ',', '.') }})
                                                    </label>
                                                    <input type="number" name="menu[{{ $menu->id }}][jumlah_pesanan]"
                                                        min="0" placeholder="Jumlah"
                                                        class="form-control form-control-sm w-25 
                                              @error('menu.' . $menu->id . '.jumlah_pesanan') is-invalid @enderror"
                                                        value="{{ old('menu.' . $menu->id . '.jumlah_pesanan', 0) }}">
                                                    <input type="hidden" name="menu[{{ $menu->id }}][id]"
                                                        value="{{ $menu->id }}">
                                                </div>
                                                @error('menu.' . $menu->id . '.jumlah_pesanan')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
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
                                <button type="submit" class=""
                                    style="background-color: orange; color: white; border: none;">
                                    Lanjutkan ke Pembayaran
                                </button>
                </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Meja Search and Pagination
            let currentMejaSearchPage = 1;
            let mejaSearchValue = '';

            document.getElementById('search_meja').addEventListener('input', function() {
                mejaSearchValue = this.value.toLowerCase();
                currentMejaSearchPage = 1;
                searchMeja();
            });

            function searchMeja() {
                fetch(`/search-meja?search=${mejaSearchValue}&page=${currentMejaSearchPage}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        const mejaList = document.querySelector('#meja_list .row');
                        mejaList.innerHTML = ''; // Clear existing items

                        // Render new items
                        result.data.forEach(meja => {
                            const mejaItem = createMejaItem(meja);
                            mejaList.appendChild(mejaItem);
                        });

                        // Update pagination
                        updateMejaPagination(result);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function createMejaItem(meja) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3 meja-item';
                col.dataset.nomor = meja.nomor_meja;
                col.dataset.lokasi = meja.location.name;

                col.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="id_meja[]" 
                               value="${meja.id}"
                               id="meja-${meja.id}">
                        <label class="form-check-label" for="meja-${meja.id}">
                            Meja ${meja.nomor_meja} 
                            (${meja.location.name})
                        </label>
                    </div>
                </div>
            </div>
        `;

                return col;
            }

            function updateMejaPagination(result) {
                const paginationContainer = document.getElementById('meja_pagination');
                paginationContainer.innerHTML = ''; // Clear existing pagination

                if (result.total_pages > 1) {
                    // Previous button
                    if (result.current_page > 1) {
                        const prevButton = document.createElement('button');
                        prevButton.textContent = 'Previous';
                        prevButton.className = 'btn btn-secondary mr-2';
                        prevButton.addEventListener('click', () => {
                            currentMejaSearchPage--;
                            searchMeja();
                        });
                        paginationContainer.appendChild(prevButton);
                    }

                    // Page numbers
                    for (let i = 1; i <= result.total_pages; i++) {
                        const pageButton = document.createElement('button');
                        pageButton.textContent = i;
                        pageButton.className =
                            `btn ${i === result.current_page ? 'btn-primary' : 'btn-secondary'} mr-1`;
                        pageButton.addEventListener('click', () => {
                            currentMejaSearchPage = i;
                            searchMeja();
                        });
                        paginationContainer.appendChild(pageButton);
                    }

                    // Next button
                    if (result.current_page < result.total_pages) {
                        const nextButton = document.createElement('button');
                        nextButton.textContent = 'Next';
                        nextButton.className = 'btn btn-secondary';
                        nextButton.addEventListener('click', () => {
                            currentMejaSearchPage++;
                            searchMeja();
                        });
                        paginationContainer.appendChild(nextButton);
                    }
                }
            }

            // Menu Search and Sorting
            document.getElementById('search_menu').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');

                menuItems.forEach(item => {
                    const nama = item.dataset.nama.toLowerCase();

                    item.style.display = nama.includes(searchValue) ?
                        'block' :
                        'none';
                });
            });

            // Sorting Menu
            document.getElementById('sort_by_menu').addEventListener('change', function() {
                const sortBy = this.value;
                const menuList = document.getElementById('menu_list');
                const menuItems = Array.from(document.querySelectorAll('.menu-item'));

                menuItems.sort((a, b) => {
                    const namaA = a.dataset.nama;
                    const namaB = b.dataset.nama;
                    return sortBy === 'asc' ?
                        namaA.localeCompare(namaB) :
                        namaB.localeCompare(namaA);
                });

                // Hapus item lama
                menuList.innerHTML = '';

                // Tambahkan item yang sudah diurutkan
                menuItems.forEach(item => menuList.appendChild(item));
            });
        });
    </script>
@endpush
