@extends('layouts.landing_page.app')

@section('content')

    <style>
        .table-card.selected {
            border: 2px solid blue;
            /* Ganti dengan warna yang diinginkan */
            box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);
            /* Tambahkan efek bayangan jika diinginkan */
        }
    </style>

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Reservasi</h1>
            <p class="text-white-50 mb-4">
                Pesan reservasi untuk pengalaman bersantap yang nyaman dan terorganisir.
                Pilih meja favorit Anda dan nikmati layanan terbaik kami.
            </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Reservasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <h1>Buat Reservasi</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="reservationForm" action="{{ route('user.reservasi.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_user" value="{{ auth()->id() }}">

            <div class="form-group">
                <label for="tanggal_reservasi">Tanggal Reservasi</label>
                <input type="date" name="tanggal_reservasi"
                    class="form-control @error('tanggal_reservasi') is-invalid @enderror"
                    value="{{ old('tanggal_reservasi') }}" required>
                @error('tanggal_reservasi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam_reservasi">Jam Reservasi</label>
                <input type="time" name="jam_reservasi" class="form-control @error('jam_reservasi') is-invalid @enderror"
                    value="{{ old('jam_reservasi') }}" required>
                @error('jam_reservasi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Section Pemilihan Meja -->
            <div class="container mt-4">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <div class="form-group mt-3">
                        <label for="id_meja">Pilih Meja</label>
                        <input type="text" id="search-table" class="form-control" placeholder="Cari meja...">
                    </div>

                    <div class="d-flex flex-wrap" id="table-list">
                        @foreach ($meja as $m)
                            <div class="col">
                                <div class="card table-card h-100" style="cursor: pointer;"
                                    id="table-card-{{ $m->id }}" onclick="toggleCheckbox({{ $m->id }})">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title">Meja {{ $m->nomor_meja }}</h5>
                                            <span class="badge"
                                                style="background-color: {{ $m->status == 'tersedia' ? 'green' : 'red' }}; color: white;">
                                                {{ ucfirst($m->status) }}
                                            </span>
                                        </div>
                                        <p class="card-text text-muted">Lokasi: {{ $m->lokasi }}</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text">Kapasitas: {{ $m->kapasitas }}</p>
                                            <p class="card-text text-muted">Lantai: {{ $m->lantai }}</p>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="id_meja[]" value="{{ $m->id }}"
                                        id="meja-{{ $m->id }}" style="display: none;">
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <!-- Section Pemilihan Menu -->
                    <div class="form-group mt-3">
                        <label for="menu">Pilih Menu (Opsional)</label>
                        <input type="text " id="search-menu" class="form-control" placeholder="Cari menu...">
                        <div class="d-flex flex-wrap overflow-auto" style="max-width: 100%; padding: 10px;" id="menu-list">
                        <form id="filterForm" action="{{ route('user.reservasi.index') }}" method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga Minimal" class="form-control">
    </div>
    <div class="col-md-4">
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga Maksimal" class="form-control">
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-primary w-100" id="filterButton">Filter</button>
    </div>
</form>

<script>
    document.getElementById('filterButton').addEventListener('click', function () {
        // Ambil elemen form
        const form = document.getElementById('filterForm');
        // Kirimkan form secara manual
        form.submit();
    });
</script>



                            @foreach ($menus as $menu)
                                <div class="card menu-card" style="width: 150px; margin: 10px; cursor: pointer;"
                                    id="menu-card-{{ $menu->id }}"
                                    onclick="toggleMenuSelection(event, {{ $menu->id }})">
                                    <button type="button" class="btn btn-danger btn-sm" id="close-{{ $menu->id }}"
                                        style="position: absolute; top: 10px; left: 10px; z-index: 2;"
                                        onclick="closeMenu({{ $menu->id }}); event.stopPropagation();">-</button>
                                    <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top"
                                        alt="{{ $menu->name }}" style="height: 120px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ $menu->name }}</h5>
                                        <p class="card-text text-center">Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                id="decrease-{{ $menu->id }}" style="display: none;"
                                                onclick="adjustQuantity({{ $menu->id }}, -1)">-</button>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                id="quantity-{{ $menu->id }}" value="0"
                                                style="width: 50px; display: none;"
                                                onchange="updateQuantity({{ $menu->id }})">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                id="increase-{{ $menu->id }}" style="display: none;"
                                                onclick="adjustQuantity({{ $menu->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="menu[{{ $menu->id }}]" value="0"
                                    id="menu-input-{{ $menu->id }}">
                            @endforeach
                        </div>
                    </div>
                    

                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-primary" onclick="showConfirmationModal()">Bayar</button>
                    </div>

        </form>

        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Reservasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama User:</strong> <span id="modal-user-name"></span></p>
                        <p><strong>Tanggal Reservasi:</strong> <span id="modal-date"></span></p>
                        <p><strong>Jam Reservasi:</strong> <span id="modal-time"></span></p>
                        <p><strong>Meja:</strong> <span id="modal-table"></span></p>
                        <p><strong>Menu yang Dipilih:</strong></p>
                        <ul id="modal-menu-list"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                <li class="page-item {{ $meja->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $meja->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <!-- Page Numbers -->
                @foreach ($meja->getUrlRange(1, $meja->lastPage()) as $page => $url)
                    <li class="page-item {{ $meja->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <!-- Next Button -->
                <li class="page-item {{ $meja->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $meja->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <style>
        .pagination {
            border-radius: 5px;
            background-color: #f9deb9;
            box-shadow: 0 2px 4px #ddd;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            border: 1px solid #ddd;
            color: #495057;
            border-radius: 5px;
        }

        .pagination .page-link:hover {
            background-color: #e28d38;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #e28d38;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
        }
    </style>




    <script>
        let selectedMenu = {};
        let currentOpenMenu = null;

        function toggleCheckbox(mejaId) {
            const checkbox = document.getElementById('meja-' + mejaId);
            const card = document.getElementById('table-card-' + mejaId);

            // Toggle checkbox
            checkbox.checked = !checkbox.checked;

            // Toggle selected class
            if (checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        }

        function toggleMenuSelection(event, menuId) {
            const menuCard = document.getElementById('menu-card-' + menuId);
            const quantityInput = document.getElementById('quantity-' + menuId);
            const decreaseButton = document.getElementById('decrease-' + menuId);
            const increaseButton = document.getElementById('increase-' + menuId);
            const closeButton = document.getElementById('close-' + menuId);

            if (event.target === closeButton) {
                menuCard.classList.remove('menu-open');
                quantityInput.style.display = 'none';
                decreaseButton.style.display = 'none';
                increaseButton.style.display = 'none';
                closeButton.style.display = 'none';
                delete selectedMenu[menuId];
                return;
            }

            if (!menuCard.classList.contains('menu-open')) {
                menuCard.classList.add('menu-open');
                quantityInput.style.display = 'block';
                decreaseButton.style.display = 'inline-block';
                increaseButton.style.display = 'inline-block';
                closeButton.style.display = 'block';
                selectedMenu[menuId] = 0;
            }
        }

        function adjustQuantity(menuId, delta) {
            const quantityInput = document.getElementById('quantity-' + menuId);
            const currentQuantity = parseInt(quantityInput.value);
            const newQuantity = currentQuantity + delta;

            if (newQuantity >= 0) {
                quantityInput.value = newQuantity;
                document.getElementById('menu-input-' + menuId).value = newQuantity;

                if (newQuantity > 0) {
                    selectedMenu[menuId] = newQuantity;
                } else {
                    delete selectedMenu[menuId];
                }
            }
        }

        function updateQuantity(menuId) {
            const quantityInput = document.getElementById('quantity-' + menuId);
            const quantity = parseInt(quantityInput.value) || 0;

            document.getElementById('menu-input-' + menuId).value = quantity;

            if (quantity > 0) {
                selectedMenu[menuId] = quantity;
            } else {
                delete selectedMenu[menuId];
            }
        }

        function showConfirmationModal() {
            const form = document.getElementById('reservationForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const userName = "{{ auth()->user()->name }}";
            const date = document.querySelector('[name="tanggal_reservasi"]').value;
            const time = document.querySelector('[name="jam_reservasi"]').value;
            const selectedTables = Array.from(document.querySelectorAll('input[name="id_meja[]"]:checked'))
                .map(input => input.closest('.table-card').querySelector('.card-title').innerText).join(', ');

            document.getElementById('modal-user-name').innerText = userName;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-time').innerText = time;
            document.getElementById('modal-table').innerText = selectedTables;

            const menuList = document.getElementById('modal-menu-list');
            menuList.innerHTML = '';

            Object.keys(selectedMenu).forEach(menuId => {
                const menuName = document.getElementById('menu-card-' + menuId).querySelector('.card-title')
                    .innerText;
                const menuQuantity = selectedMenu[menuId];

                const menuItem = document.createElement('li');
                menuItem.textContent = `${menuName}: ${menuQuantity} item`;
                menuList.appendChild(menuItem);
            });

            if (Object.keys(selectedMenu).length === 0) {
                const noMenuMessage = document.createElement('li');
                noMenuMessage.textContent = 'Tidak ada menu dipilih';
                noMenuMessage.style.fontStyle = 'italic';
                menuList.appendChild(noMenuMessage);
            }

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        }

        function submitForm() {
            const formData = new FormData(document.getElementById('reservationForm'));
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            document.getElementById('reservationForm').submit();
        }

        // Search functionality for tables
        document.getElementById('search-table').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableCards = document.querySelectorAll('.table-card');
            tableCards.forEach(card => {
                const title = card.querySelector('.card-title').innerText.toLowerCase();
                card.style.display = title.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Search functionality for menus
        document.getElementById('search-menu').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const menuCards = document.querySelectorAll('.menu-card');
            menuCards.forEach(card => {
                const title = card.querySelector('.card-title').innerText.toLowerCase();
                card.style.display = title.includes(searchTerm) ? 'block' : 'none';
            });
        });

        const style = document.createElement('style');
        style.textContent = `
        .menu-open {
            border: 2px solid #007bff;
        }
    `;
        document.head.appendChild(style);



        
    </script>

@endsection
