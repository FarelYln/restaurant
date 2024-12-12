@extends('layouts.landing_page.app')

@section('content')
    {{-- Informasi Reservasi --}}
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
            <div class="card mb-4 shadow">
                <div class="card-header  bg-primary text-white">
                    <h4 class="mb-0">Pilih Meja</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search_meja" class="form-control"
                                placeholder="Cari meja (nomor/lokasi)...">
                        </div>
                        <div class="col-md-6">
                            <select id="sort_by_meja" class="form-select">
                                <option value="">Urutkan Meja</option>
                                <option value="asc">Nomor Meja (A-Z)</option>
                                <option value="desc">Nomor Meja (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    <div id="meja_list" class="row row-cols-1 row-cols-md-3 g-3">
                        @foreach ($meja as $m)
                            <div class="col">
                                <div class="card h-100">
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
                    @error('id_meja')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Pilih Menu --}}
            <div class="card mb-4 shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pilih Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search_menu" class="form-control" placeholder="Cari menu...">
                        </div>
                        <div class="col-md-6">
                            <select id="sort_by_menu" class="form-select">
                                <option value="">Urutkan Menu</option>
                                <option value="asc">Nama Menu (A-Z)</option>
                                <option value="desc">Nama Menu (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    <div id="menu_list" class="row">
                        @foreach ($menus as $menu)
                            <div class="col-12 mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $menu->image_url ?? asset('images/default-menu.png') }}"
                                        class="img-fluid rounded me-3" alt="{{ $menu->nama_menu }}"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                    <label class="flex-grow-1">
                                        {{ $menu->nama_menu }}
                                        (Rp. {{ number_format($menu->harga, 0, ',', '.') }})
                                    </label>
                                    <input type="number" name="menu[{{ $menu->id }}][jumlah_pesanan]" min="0"
                                        class="form-control form-control-sm w-25">
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn- bg-primary text-white">
                    Lanjutkan ke Pembayaran
                </button>
            </div>
        </form>
    </div>
@endsection
