@extends('layouts.landing_page.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Reservasi</h1>
    
    <form action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf
        
        {{-- Tanggal dan Jam Reservasi --}}
        <div class="card mb-3">
            <div class="card-header">
                <h4>Informasi Reservasi</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_reservasi">Tanggal Reservasi</label>
                            <input type="date" 
                                   class="form-control @error('tanggal_reservasi') is-invalid @enderror"
                                   name="tanggal_reservasi" 
                                   value="{{ old('tanggal_reservasi') }}" 
                                   required>
                            @error('tanggal_reservasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_reservasi">Jam Reservasi</label>
                            <input type="time" 
                                   class="form-control @error('jam_reservasi') is-invalid @enderror"
                                   name="jam_reservasi" 
                                   value="{{ old('jam_reservasi') }}" 
                                   required>
                            @error('jam_reservasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pilih Meja --}}
        <div class="card mb-3">
            <div class="card-header">
                <h4>Pilih Meja</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Filter dan Search Meja --}}
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" 
                                       id="search_meja" 
                                       class="form-control" 
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
                                <div class="col-md-4 mb-3 meja-item" 
                                     data-nomor="{{ $m->nomor_meja }}" 
                                     data-lokasi="{{ $m->location->name }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="id_meja[]" 
                                                       value="{{ $m->id }}"
                                                       id="meja-{{ $m->id }}"
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
                    </div>
                </div>
                @error('id_meja')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Pilih Menu --}}
        <div class="card mb-3">
            <div class="card-header">
                <h4>Pilih Menu</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" 
                               id="search_menu" 
                               class="form-control" 
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
                        <div class="menu-item mb-3" 
                             data-nama="{{ $menu->nama_menu }}" 
                             data-harga="{{ $menu->harga }}">
                            <div class="d-flex align-items-center">
                                <label class="mr-3 flex-grow-1">
                                    {{ $menu->nama_menu }} 
                                    (Rp. {{ number_format($menu->harga, 0, ',', '.') }})
                                </label>
                                <input type="number" 
                                       name="menu[{{ $menu->id }}][jumlah_pesanan]"
                                       min="0" 
                                       placeholder="Jumlah"
                                       class="form-control form-control-sm w-25 
                                              @error('menu.' . $menu->id . '.jumlah_pesanan') is-invalid @enderror"
                                       value="{{ old('menu.' . $menu->id . '.jumlah_pesanan', 0) }}">
                                <input type="hidden" 
                                       name="menu[{{ $menu->id }}][id]"
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
            <button type="submit" class="btn btn-primary btn-lg">
                Lanjutkan ke Pembayaran
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi Search Meja
    document.getElementById('search_meja').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const mejaItems = document.querySelectorAll('.meja-item');
        
        mejaItems.forEach(item => {
            const nomor = item.dataset.nomor.toLowerCase();
            const lokasi = item.dataset.lokasi.toLowerCase();
            
            item.style.display = (nomor.includes(searchValue) || lokasi.includes(searchValue)) 
                ? 'block' 
                : 'none';
        });
    });

    // Fungsi Sort Meja
    document.getElementById('sort_by_meja').addEventListener('change', function() {
        const sortBy = this.value;
        const mejaList = document.querySelector('#meja_list .row');
        const mejaItems = Array.from(document.querySelectorAll('.meja-item'));

        mejaItems.sort((a, b) => {
            const nomorA = a.dataset.nomor;
            const nomorB = b.dataset.nomor;
            return sortBy === 'asc' 
                ? nomorA.localeCompare(nomorB) 
                : nomorB.localeCompare(nomorA);
        });

        // Hapus item lama
        mejaList.innerHTML = '';

        // Tambahkan item yang sudah diurutkan
        mejaItems.forEach(item => mejaList.appendChild(item));
    });

    // Fungsi Search Menu
    document.getElementById('search_menu').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const nama = item.dataset.nama.toLowerCase();
            
            item.style.display = nama.includes(searchValue) 
                ? 'block' 
                : 'none';
        });
    });

    // Fungsi Sort Menu
    document.getElementById('sort_by_menu').addEventListener('change', function() {
        const sortBy = this.value;
        const menuList = document.getElementById('menu_list');
        const menuItems = Array.from(document.querySelectorAll('.menu-item'));

        menuItems.sort((a, b) => {
            const namaA = a.dataset.nama;
            const namaB = b.dataset.nama;
            return sortBy === 'asc' 
                ? namaA.localeCompare(namaB) 
                : namaB.localeCompare(namaA);
        });

        // Hapus item lama
        menuList.innerHTML = '';

        // Tambahkan item yang sudah diurutkan
        menuItems.forEach(item => menuList.appendChild(item));
    });
});
</script>
@endpush