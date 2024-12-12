@extends('layouts.landing_page.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center mb-0">Halaman Pembayaran</h2>
                </div>
                
                <div class="card-body">
                    {{-- Menampilkan error jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Detail Reservasi --}}
                    <div class="mb-4">
                        <h4 class="text-primary">Detail Reservasi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tanggal:</strong> {{ $reservasiData->tanggal_reservasi->format('d M Y H:i') }}</p>
                                <p><strong>Meja:</strong> 
                                    @foreach($reservasiData->meja as $meja)
                                        {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Menu --}}
                    <div class="mb-4">
                        <h4 class="text-primary">Menu Pesanan</h4>
                        @if($reservasiData->menus->isEmpty())
                            <div class="alert alert-danger">Tidak ada menu yang dipilih.</div>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach($reservasiData->menus as $menu)
                                        <tr>
                                            <td>{{ $menu->nama_menu }}</td>
                                            <td>{{ $menu->pivot->jumlah_pesanan }}</td>
                                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($menu->harga * $menu->pivot->jumlah_pesanan, 0, ',', '.') }}</td>
                                        </tr>
                                        @php $subtotal += $menu->harga * $menu->pivot->jumlah_pesanan @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-active">
                                        <td colspan="3" class="text-right"><strong>Total Harga</strong></td>
                                        <td><strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>

                    {{-- Form Pembayaran --}}
                    @if(!$reservasiData->menus->isEmpty())
                        <form action="{{ route('user.reservasi.confirm', ['id' => $reservasiData->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                            
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Pilih Metode Pembayaran</label>
                                <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="scan">Scan</option>
                                    <option value="kartu_kredit">Kartu Kredit</option>
                                    <option value="e_wallet">E-Wallet</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="payment_amount" class="form-label">Jumlah Pembayaran</label>
                                <input type="text" name="payment_amount" class="form-control" 
                                       value="Rp {{ number_format($totalPrice, 0, ',', '.') }}" readonly>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Konfirmasi Pembayaran
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning text-center">
                            Silakan pilih menu sebelum melanjutkan ke pembayaran.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Tambahkan validasi atau interaksi tambahan di sini
</script>
@endpush