@extends('layouts.landing_page.app')

@section('content')
<br>
<br>
<br>
<div class="container">
    <h1>Daftar Reservasi</h1>

    <a href="{{ route('user.reservasi.create') }}" class="btn btn-primary mb-3">Buat Reservasi Baru</a> <!-- Tombol untuk mengarah ke halaman create -->


    @if($reservasiData->isEmpty())
        <p>Tidak ada reservasi yang memiliki status confirmed atau completed.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal Reservasi</th>
                    <th>Status Reservasi</th>
                    <th>Meja</th>
                    <th>Menu Pesanan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservasiData as $reservasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</td>
                        <td>{{ ucfirst($reservasi->status_reservasi) }}</td>
                        <td>
                            @foreach($reservasi->meja as $meja)
                                {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($reservasi->menus as $menu)
                                {{ $menu->nama_menu }} (Jumlah: {{ $menu->pivot->jumlah_pesanan }})<br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                            return $menu->pivot->jumlah_pesanan * $menu->harga;
                        }), 0, ',', '.') }}</td>
                         <td>
                            <a href="{{ route('user.reservasi.nota', $reservasi->id) }}" class="btn btn-info">Lihat Nota</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection