@extends('layouts.landing_page.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Pembayaran</h1>
        <div class="card mb-4 shadow mt-5"> <!-- Menambahkan margin-top hanya pada card ini -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Pembayaran</h4>
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

                    @if(!$reservasiData->menus->isEmpty())
                    <form action="{{ route('user.reservasi.confirm', ['id' => $reservasiData->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Pilih Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Pilih Metode</option>
                                <option value="scan">Scan</option>
                                <option value="kartu_kredit">Kartu Kredit</option>
                                <option value="e_wallet">E-Wallet</option>
                            </select>
                        </div>
                    
                        {{-- Kontainer untuk metode pembayaran spesifik --}}
                        <div id="payment_details" style="display:none;">
                            {{-- E-Wallet --}}
                            <div id="e_wallet_section" style="display:none;">
                                <div class="mb-3">
                                    <label>Pilih Provider E-Wallet</label>
                                    <select name="e_wallet_provider" class="form-control">
                                        <option value="ovo">OVO</option>
                                        <option value="gopay">GoPay</option>
                                        <option value="dana">Dana</option>
                                        <option value="shopeepay">ShopeePay</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Nomor E-Wallet</label>
                                    <input type="text" name="e_wallet_number" class="form-control" 
                                           placeholder="Masukkan nomor E-Wallet">
                                </div>
                            </div>
                    
                            {{-- Kartu Kredit --}}
                            <div id="credit_card_section" style="display:none;">
                                <div class="mb-3">
                                    <label>Tipe Kartu Kredit</label>
                                    <select name="credit_card_type" class="form-control">
                                        <option value="visa">Visa</option>
                                        <option value="mastercard">Mastercard</option>
                                        <option value="american_express">American Express</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Nomor Kartu Kredit</label>
                                    <input type="text" name="credit_card_number" class="form-control" 
                                           placeholder="Masukkan nomor kartu kredit">
                                </div>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('payment_method').addEventListener('change', function() {
    const paymentDetails = document.getElementById('payment_details');
    const eWalletSection = document.getElementById('e_wallet_section');
    const creditCardSection = document.getElementById('credit_card_section');

    paymentDetails.style.display = this.value !== '' ? 'block' : 'none';
    eWalletSection.style.display = this.value === 'e_wallet' ? 'block' : 'none';
    creditCardSection.style.display = this.value === 'kartu_kredit' ? 'block' : 'none';
});
</script>
@endpush