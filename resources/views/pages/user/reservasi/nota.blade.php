@extends('layouts.landing_page.app')

@section('content')
    <div class="container mt-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Header Nota --}}
                <div class="card" style="margin-top: 150px;">
                    <div class="card-header text-center"
                         style="background-color: #ffffff; border: none;">
                        <h2 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: bold;">
                            <i class="fas fa-receipt"></i> Nota Pembayaran
                        </h2>
                    </div>

                    {{-- Konten Nota --}}
                    <div class="card-body" style="font-family: 'Arial', sans-serif; font-size: 14px; line-height: 1.6;">
                        {{-- Detail Reservasi --}}
                        <div class="mb-4">
                            <h4 class="text-dark" style="font-weight: bold; font-size: 16px;">Detail Reservasi</h4>
                            <p><strong>ID Reservasi:</strong> {{ $reservasi->id }}</p>
                            <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
                            <p><strong>Meja:</strong>
                                @foreach($reservasi->meja as $meja)
                                    {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>

                        {{-- Pesanan Menu --}}
                        <div class="mb-4">
                            <h4 class="text-dark" style="font-weight: bold; font-size: 16px;">Pesanan Menu</h4>
                            <table class="table table-bordered table-sm" style="font-size: 13px; text-align: left;">
                                <thead style="background-color: #f8f9fa; font-weight: bold;">
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
                                <tfoot style="font-weight: bold;">
                                    <tr>
                                        <td colspan="3" class="text-end">Total Harga</td>
                                        <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Detail Pembayaran --}}
                        <div class="mb-4">
                            <h4 class="text-dark" style="font-weight: bold; font-size: 16px;">Detail Pembayaran</h4>
                            <p><strong>Total Harga:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                            <p><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', $reservasi->metode_pembayaran) }}</p>
                            <p><strong>Media Pembayaran:</strong>
                                @if($reservasi->media_pembayaran)
                                    {{ strtoupper($reservasi->media_pembayaran) }} ({{ $reservasi->nomor_media }})
                                @else
                                    Tidak Ada
                                @endif
                            </p>
                        </div>

                        {{-- Tombol Cetak --}}
                        <div class="text-center">
                            <button onclick="window.print()" class="btn btn-primary" style="border-radius: 25px; padding: 10px 20px;">
                                <i class="fas fa-print"></i> Cetak Nota
                            </button>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer text-center text-muted" style="font-size: 12px; padding: 10px 0;">
                        <small>Terima kasih telah melakukan reservasi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            padding: 20px;
            border: 1px solid #ddd;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .card {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn {
                display: none;
            }
        }
    </style>
@endpush
