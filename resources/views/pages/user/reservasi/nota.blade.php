@extends('layouts.landing_page.app')

@section('content')
<br>
<br>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h2 class="text-center mb-0">
                        <i class="fas fa-receipt"></i> Nota Pembayaran
                    </h2>
                </div>
                
                <div class="card-body">
                    {{-- Informasi Reservasi --}}
                    <div class="mb-4">
                        <h4 class="text-success">Detail Reservasi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID Reservasi:</strong> {{ $reservasi->id }}</p>
                                <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
                                <p><strong>Meja:</strong> 
                                    @foreach($reservasi->meja as $meja)
                                        {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Menu --}}
                    <div class="mb-4">
                        <h4 class="text-success">Pesanan Menu</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalHarga = 0; @endphp
                                @foreach($reservasi->menus as $menu)
                                    @php 
                                        $subtotal = $menu->pivot->jumlah_pesanan * $menu->harga;
                                        $totalHarga += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $menu->nama_menu }}</td>
                                        <td>{{ $menu->pivot->jumlah_pesanan }}</td>
                                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3" class="text-right"><strong>Total Harga</strong></td>
                                    <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Informasi Pembayaran --}}
                    <div class="mb-4">
                        <h4 class="text-success">Detail Pembayaran</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Total Harga:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                                <p><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                                <p><strong>Media Pembayaran:</strong> 
                                    @if($reservasi->media_pembayaran)
                                        {{ strtoupper($reservasi->media_pembayaran) }} 
                                        ({{ $reservasi->nomor_media }})
                                    @else
                                        Tidak Ada
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="text-center">
                        <button onclick="window.print()" class="btn btn-outline-success me-2">
                            <i class="fas fa-print"></i> Cetak Nota
                        </button>
                        <a href="{{ route('user.reservasi.index') }}" class="btn btn-success">
                            <i class="fas fa-home"></i> Kembali ke Beranda Reservasi
                        </a>
                    </div>
                </div>

                {{-- Footer Nota --}}
                <div class="card-footer text-center text-muted">
                    Terima kasih telah melakukan reservasi
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Optional: Tambahkan fungsi tambahan jika diperlukan
</script>
@endpush