@extends('layouts.landing_page.app')

@section('content')


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

            <div class="form-group mt-3">
                <label for="id_meja">Pilih Meja</label>
                <select name="id_meja" class="form-control @error('id_meja') is-invalid @enderror" required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach ($meja as $m)
                        <option value="{{ $m->id }}" {{ old('id_meja') == $m->id ? 'selected' : '' }}>
                            {{ $m->nomor_meja }}</option>
                    @endforeach
                </select>
                @error('id_meja')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="menu">Pilih Menu (Opsional)</label>
                <div class="d-flex flex-wrap overflow-auto" style="max-width: 100%; padding: 10px;">
                    @foreach ($menus as $menu)
                        <div class="card" style="width: 150px; margin: 10px; cursor: pointer;"
                            id="menu-card-{{ $menu->id }}" onclick="toggleMenuSelection(event, {{ $menu->id }})">
                            <button type="button" class="btn btn-danger btn-sm" id="close-{{ $menu->id }}"
                                style="position: absolute; top: 10px; left: 10px; z-index: 2;"
                                onclick="closeMenu({{ $menu->id }}); event.stopPropagation();">-</button>
                            <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top"
                                alt="{{ $menu->name }}" style="height: 120px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $menu->name }}</h5>
                                <p class="card-text text-center">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        id="decrease-{{ $menu->id }}" style="display: none;"
                                        onclick="adjustQuantity({{ $menu->id }}, -1)">-</button>
                                    <input type="number" class="form-control form-control-sm text-center"
                                        id="quantity-{{ $menu->id }}" value="0"
                                        style="width: 50px; display: none;" onchange="updateQuantity({{ $menu->id }})">
                                    <button type="button" class="btn btn-primary btn-sm" id="increase-{{ $menu->id }}"
                                        style="display: none;" onclick="adjustQuantity({{ $menu->id }}, 1)">+</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="menu[{{ $menu->id }}]" value="0"
                            id="menu-input-{{ $menu->id }}">
                    @endforeach
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="button" class="btn btn-primary" onclick="showConfirmationModal()">Save</button>
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

    <script>
        let selectedMenu = {};
        let currentOpenMenu = null;

        function toggleMenuSelection(event, menuId) {
            const menuCard = document.getElementById('menu-card-' + menuId);
            const quantityInput = document.getElementById('quantity-' + menuId);
            const decreaseButton = document.getElementById('decrease-' + menuId);
            const increaseButton = document.getElementById('increase-' + menuId);
            const closeButton = document.getElementById('close-' + menuId);

            // Cek apakah yang diklik adalah tombol close
            if (event.target === closeButton) {
                // Tutup menu saat tombol close diklik
                menuCard.classList.remove('menu-open');
                quantityInput.style.display = 'none';
                decreaseButton.style.display = 'none';
                increaseButton.style.display = 'none';
                closeButton.style.display = 'none';

                // Reset currentOpenMenu hanya jika menu yang sama yang sedang terbuka
                if (currentOpenMenu === menuId) {
                    currentOpenMenu = null;
                }
                return;
            }

            // Jika menu sudah terbuka dan bukan tombol close yang diklik
            if (menuCard.classList.contains('menu-open')) {
                return;
            }

            // Tutup menu yang sebelumnya terbuka (jika ada)
            if (currentOpenMenu !== null) {
                const prevOpenMenuCard = document.getElementById('menu-card-' + currentOpenMenu);
                if (prevOpenMenuCard) {
                    prevOpenMenuCard.classList.remove('menu-open');
                    document.getElementById('quantity-' + currentOpenMenu).style.display = 'none';
                    document.getElementById('decrease-' + currentOpenMenu).style.display = 'none';
                    document.getElementById('increase-' + currentOpenMenu).style.display = 'none';
                    document.getElementById('close-' + currentOpenMenu).style.display = 'none';
                }
            }

            // Buka menu baru
            menuCard.classList.add('menu-open');
            quantityInput.style.display = 'block';
            decreaseButton.style.display = 'inline-block';
            increaseButton.style.display = 'inline-block';
            closeButton.style.display = 'block';

            // Set menu yang sedang terbuka
            currentOpenMenu = menuId;
        }

        function adjustQuantity(menuId, delta) {
            const quantityInput = document.getElementById('quantity-' + menuId);
            const currentQuantity = parseInt(quantityInput.value);
            const newQuantity = currentQuantity + delta;

            if (newQuantity >= 0) {
                quantityInput.value = newQuantity;
                document.getElementById('menu-input-' + menuId).value = newQuantity;

                // Update selectedMenu
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

            // Update selectedMenu
            if (quantity > 0) {
                selectedMenu[menuId] = quantity;
            } else {
                delete selectedMenu[menuId];
            }
        }

        function showConfirmationModal() {
            // Validasi form sebelum membuka modal
            const form = document.getElementById('reservationForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Tambahkan log untuk debugging
            console.log('Selected Menu:', selectedMenu);

            const userName = "{{ auth()->user()->name }}";
            const date = document.querySelector('[name="tanggal_reservasi"]').value;
            const time = document.querySelector('[name="jam_reservasi"]').value;
            const table = document.querySelector('[name="id_meja"]').options[document.querySelector('[name="id_meja"]')
                .selectedIndex].text;

            document.getElementById('modal-user-name').innerText = userName;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-time').innerText = time;
            document.getElementById('modal-table').innerText = table;

            const menuList = document.getElementById('modal-menu-list');
            menuList.innerHTML = ''; // Kosongkan daftar menu

            // Pastikan hidden input diupdate sebelum submit
            Object.keys(selectedMenu).forEach(menuId => {
                const hiddenInput = document.getElementById('menu-input-' + menuId);
                if (hiddenInput) {
                    hiddenInput.value = selectedMenu[menuId];
                }
            });

            // Cek apakah ada menu yang dipilih
            if (Object.keys(selectedMenu).length > 0) {
                for (const menuId in selectedMenu) {
                    const menuName = document.getElementById('menu-card-' + menuId).querySelector('.card-title').innerText;
                    const menuQuantity = selectedMenu[menuId];

                    const menuItem = document.createElement('li');
                    menuItem.textContent = `${menuName}: ${menuQuantity} item`;
                    menuList.appendChild(menuItem);
                }
            } else {
                const noMenuMessage = document.createElement('li');
                noMenuMessage.textContent = 'Tidak ada menu dipilih';
                noMenuMessage.style.fontStyle = 'italic';
                menuList.appendChild(noMenuMessage);
            }

            // Tampilkan modal konfirmasi
            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        }

        function submitForm() {
            // Log form data sebelum submit
            const formData = new FormData(document.getElementById('reservationForm'));
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            document.getElementById('reservationForm').submit();
        }

        // Tambahkan CSS untuk mendukung interaksi
        const style = document.createElement('style');
        style.textContent = `
    .menu-open {
        border: 2px solid #007bff;
    }
`;
        document.head.appendChild(style);
    </script>


@endsection
