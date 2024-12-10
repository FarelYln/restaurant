@extends('layouts.landing_page.app')

@section('content')
<br>
<br>
<br>
<div class="container">
    <h1>Halaman Pembayaran</h1>
    
    <h4>Detail Reservasi</h4>
    <p>Tanggal: {{ $reservasiData->tanggal_reservasi->format('d M Y H:i') }}</p>
    <p>Meja: 
        @foreach($reservasiData->meja as $meja)
            {{ $meja->nomor_meja }}@if(!$loop->last), @endif
        @endforeach
    </p>
    
    <h4>Menu Pesanan:</h4>
    <ul>
        @foreach($reservasiData->menus as $menu)
            <li>{{ $menu->nama_menu }} - Jumlah: {{ $menu->pivot->jumlah_pesanan }} - Harga: Rp {{ number_format($menu->harga, 0, ',', '.') }}</li>
        @endforeach
    </ul>
    
    <h4>Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>

    <!-- Form untuk konfirmasi pembayaran -->
    <form action="{{ route('user.reservasi.confirm', ['id' => $reservasiData->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
    </form>
</div>
@endsection
