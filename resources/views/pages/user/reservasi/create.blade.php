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
            <input type="date" class="form-control" name="tanggal_reservasi" value="{{ old('tanggal_reservasi') }}" required>
        </div>
        <div class="form-group">
            <label for="jam_reservasi">Jam Reservasi</label>
            <input type="time" class="form-control" name="jam_reservasi" value="{{ old('jam_reservasi') }}" required>
        </div>

        <h4>Pilih Meja</h4>
        @foreach($meja as $m)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="id_meja[]" value="{{ $m->id }}" {{ in_array($m->id, old('id_meja', [])) ? 'checked' : '' }}>
                <label class="form-check-label">{{ $m->nomor_meja }}</label>
            </div>
        @endforeach

        <h4>Pilih Menu</h4>
        <div id="menu-container">
            @foreach($menus as $menu)
                <div class="form-group">
                    <label>{{ $menu->nama_menu }}</label>
                    <input type="number" name="menu[{{ $menu->id }}][jumlah_pesanan]" min="1" placeholder="Jumlah Pesanan" class="form-control" value="{{ old('menu.'.$menu->id.'.jumlah_pesanan') }}">
                    <input type="hidden" name="menu[{{ $menu->id }}][id]" value="{{ $menu->id }}">
                </div>
            @endforeach
        </div>

        <!-- Input status reservasi, disembunyikan -->
        <input type="hidden" name="status_reservasi" value="pending">
        <button type="submit" class="btn btn-primary">
            Lanjutkan ke Pembayaran
        </button>
    </form>

    @if(session('orderDetails'))
    <!-- Modal Structure -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Detail Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Menu Pesanan:</h6>
                    <ul>
                        @foreach(session('orderDetails')['menus'] as $menu)
                            <li>{{ $menu['name'] }} - Jumlah: {{ $menu['jumlah_pesanan'] }}</li>
                        @endforeach
                    </ul>
                    <h6>Meja yang dipilih:</h6>
                    <ul>
                        @foreach(session('orderDetails')['meja'] as $meja)
                            <li>{{ $meja }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <a href="{{ route('user.reservasi.payment', ['id' => session('reservasi_id')]) }}" class="btn btn-primary">
                        Lanjutkan ke Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection