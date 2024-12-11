@extends('layouts.landing_page.app')

@section('content')
<br>
<br>
<br>
<div class="container">
    <h1>Reservasi</h1>
    <!-- Form untuk reservasi -->
    <form action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf
        <!-- Input untuk tanggal dan jam reservasi -->
        <div class="form-group">
            <label for="tanggal_reservasi">Tanggal Reservasi</label>
            <input type="date" class="form-control @error('tanggal_reservasi') is-invalid @enderror" 
                   name="tanggal_reservasi" 
                   value="{{ old('tanggal_reservasi') }}" 
                   required>
            @error('tanggal_reservasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jam_reservasi">Jam Reservasi</label>
            <input type="time" class="form-control @error('jam_reservasi') is-invalid @enderror" 
                   name="jam_reservasi" 
                   value="{{ old('jam_reservasi') }}" 
                   required>
            @error('jam_reservasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilih Meja -->
        <div class="form-group">
            <h4>Pilih Meja</h4>
            @foreach($meja as $m)
                <div class="form-check">
                    <input class="form-check-input @error('id_meja') is-invalid @enderror" 
                           type="checkbox" 
                           name="id_meja[]" 
                           value="{{ $m->id }}" 
                           id="meja-{{ $m->id }}"
                           {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="meja-{{ $m->id }}">
                        Nomor Meja {{ $m->nomor_meja }}
                    </label>
                </div>
            @endforeach
            @error('id_meja')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

<!-- Pilih Menu -->
<div class="form-group">
    <h4>Pilih Menu</h4>
    @foreach($menus as $menu)
        <div class="menu-item mb-3">
            <div class="d-flex align-items-center">
                <label class="mr-3 flex-grow-1">
                    {{ $menu->nama_menu }} 
                    (Rp. {{ number_format($menu->harga, 0, ',', '.') }})
                </label>
                <input type="number" 
                       name="menu[{{ $menu->id }}][jumlah_pesanan]" 
                       min="0" 
                       placeholder="Jumlah" 
                       class="form-control form-control-sm w-25 @error('menu.'.$menu->id.'.jumlah_pesanan') is-invalid @enderror"
                       value="{{ old('menu.'.$menu->id.'.jumlah_pesanan', 0) }}">
                <input type="hidden" 
                       name="menu[{{ $menu->id }}][id]" 
                       value="{{ $menu->id }}">
            </div>
            @error('menu.'.$menu->id.'.jumlah_pesanan')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    @endforeach
    @error('menu')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

        <!-- Input status reservasi, disembunyikan -->
        <input type="hidden" name="status_reservasi" value="pending">
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Lanjutkan ke Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection