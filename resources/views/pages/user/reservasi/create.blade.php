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
                                        data-nomor="{{ $m->kapasitas }}"
                                        data-lokasi="{{ $m->location->name }}"
                                        data-lokasi="{{ $m->location->floor }}">
                                       
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="id_meja[]"
                                                        value="{{ $m->id }}" id="meja-{{ $m->id }}"
                                                        {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="meja-{{ $m->id }}">
                                                        Meja {{ $m->nomor_meja }}
                                                        Kapasitas{{ $m->kapasitas }}
                                                        ({{ $m->location->name }})
                                                        ({{ $m->location->floor }})
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

                                    <div class="row" id="menu_list">
                                        @foreach ($menus as $menu)
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100">
                                                    <!-- Menampilkan Gambar -->
                                                    @if ($menu->image)
                                                        <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->nama_menu }}">
                                                    @else
                                                        <img src="{{ asset('images/default-menu.jpg') }}" class="card-img-top" alt="Default Image">
                                                    @endif
                                    
                                                    <div class="card-body d-flex flex-column justify-content-between">
                                                        <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                                                        <p class="card-text">Rp. {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    
                                                        <!-- Menampilkan Nama Kategori -->
                                                        <p class="card-text">
                                                            <small>Kategori: 
                                                                @foreach ($menu->categories as $category)
                                                                    <span class="badge bg-primary">{{ $category->nama_kategori }}</span>
                                                                @endforeach
                                                            </small>
                                                        </p>
                                    
                                                        <!-- Input Jumlah Pesanan -->
                                                        <div class="d-flex align-items-center">
                                                            <button type="button" class="btn btn-outline-primary btn-sm me-2 increment-btn"
                                                                    data-target="#menu-quantity-{{ $menu->id }}">
                                                                +
                                                            </button>
                                                            <input type="number" id="menu-quantity-{{ $menu->id }}"
                                                                   name="menu[{{ $menu->id }}][jumlah_pesanan]"
                                                                   class="form-control form-control-sm text-center w-25"
                                                                   value="{{ old('menu.' . $menu->id . '.jumlah_pesanan', 0) }}" min="0">
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
                                    
                                     {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $menus->links('pagination::bootstrap-4') }}
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
                    col.dataset.lokasi = meja.location.floor;
                    col.dataset.nomor = meja.kapasitas;

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
                            (${meja.location.floor})
                            (${meja.kapasitas})
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
 // Menu Search and Pagination
 let currentMenuSearchPage = 1;
    let menuSearchValue = '';

    document.getElementById('search_menu').addEventListener('input', function() {
        menuSearchValue = this.value.toLowerCase();
        currentMenuSearchPage = 1;
        searchMenu();
    });

    function searchMenu() {
        fetch(`/search-menu?search=${menuSearchValue}&page=${currentMenuSearchPage}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            const menuList = document.getElementById('menu_list');
            menuList.innerHTML = ''; // Clear existing items

            // Render new items
            result.data.forEach(menu => {
                const menuItem = createMenuItem(menu);
                menuList.appendChild(menuItem);
            });

            // Update pagination
            updateMenuPagination(result);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function createMenuItem(menu) {
    const col = document.createElement('div');
    col.className = 'col-md-4 mb-4 menu-item';
    col.dataset.nama = menu.nama_menu.toLowerCase();
    col.innerHTML = `
        <div class="card h-100">
            <img src="${menu.image}" class="card-img-top" alt="${menu.nama_menu}">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">${menu.nama_menu}</h5>
                <p class="card-text">Rp. ${formatCurrency(menu.harga)}</p>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary btn-sm me-2 increment-btn" 
                            data-target="#menu-quantity-${menu.id}">
                        +
                    </button>
                    <input type="number" id="menu-quantity-${menu.id}"
                           name="menu[${menu.id}][jumlah_pesanan]"
                           class="form-control form-control-sm text-center w-25"
                           value="0" min="0">
                    <input type="hidden" name="menu[${menu.id}][id]" value="${menu.id}">
                </div>
            </div>
        </div>
    `;

    // Tambahkan event listener untuk tombol increment
    const incrementBtn = col.querySelector('.increment-btn');
    const quantityInput = col.querySelector(`#menu-quantity-${menu.id}`);

    incrementBtn.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value) || 0;
        quantityInput.value = currentValue + 1;
    });

    // Validasi input
    quantityInput.addEventListener('input', () => {
        const value = parseInt(quantityInput.value);
        if (isNaN(value) || value < 0) {
            quantityInput.value = 0;
        }
    });

    return col;
}

    function updateMenuPagination(result) {
        const paginationContainer = document.getElementById('menu_pagination');
        paginationContainer.innerHTML = ''; // Clear existing pagination

        if (result.total_pages > 1) {
            // Previous button
            if (result.current_page > 1) {
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary mr-2';
                prevButton.addEventListener('click', () => {
                    currentMenuSearchPage--;
                    searchMenu();
                });
                paginationContainer.appendChild(prevButton);
            }

            // Page numbers
            for (let i = 1; i <= result.total_pages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = `btn ${i === result.current_page ? 'btn-primary' : 'btn-secondary'} mr-1`;
                pageButton.addEventListener('click', () => {
                    currentMenuSearchPage = i;
                    searchMenu();
                });
                paginationContainer.appendChild(pageButton);
            }

            // Next button
            if (result.current_page < result.total_pages) {
                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.addEventListener('click', () => {
                    currentMenuSearchPage++;
                    searchMenu();
                });
                paginationContainer.appendChild(nextButton);
            }
        }
    }

    // Utility function to format currency
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', { 
            minimumFractionDigits: 0, 
            maximumFractionDigits: 0 
        }).format(number);
    }

    // Sorting Menu (Modified to work with pagination)
    document.getElementById('sort_by_menu').addEventListener('change', function() {
        const sortBy = this.value;
        currentMenuSearchPage = 1;
        
        fetch(`/sort-menu?sort_by=${sortBy}&page=${currentMenuSearchPage}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            const menuList = document.getElementById('menu_list');
            menuList.innerHTML = ''; // Clear existing items

            // Render new items
            result.data.forEach(menu => {
                const menuItem = createMenuItem(menu);
                menuList.appendChild(menuItem);
            });

            // Update pagination
            updateMenuPagination(result);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
            });
        </script>
    @endpush
