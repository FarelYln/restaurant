@extends('layouts.landing_page.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Konfirmasi Pembayaran Reservasi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Detail Reservasi</h5>
                            <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y') }}</p>
                            <p><strong>Jam Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('H:i') }}</p>
                            <p><strong>Nomor Meja:</strong> {{ $reservasi->meja->nomor_meja }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5>Total Pembayaran</h5>
                            <h3 class="text-primary">Rp. {{ number_format($reservasi->total_harga, 0, ',', '.') }}</h3>
                        </div>
                    </div>

                    <form action="{{ route('user.reservasi.payment.process', $reservasi->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach($paymentMethods as $key => $method)
                                    <option value="{{ $key }}" {{ old('payment_method') == $key ? 'selected' : '' }}>
                                        {{ $method }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Field khusus kartu kredit -->
                        <div id="kartu_kredit_fields" style="display: none;">
                            <div class="form-group">
                                <label>Nomor Kartu</label>
                                <input type="text" 
                                       name="nomor_kartu" 
                                       id="nomor_kartu"
                                       class="form-control @error('nomor_kartu') is-invalid @enderror" 
                                       value="{{ old('nomor_kartu') }}"
                                       placeholder="Masukkan nomor kartu"
                                       pattern="\d{16,19}"
                                       maxlength="19">
                                @error('nomor_kartu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pembayaran</label>
                                <input type="text" 
                                       name="jumlah_bayar" 
                                       id="jumlah_bayar"
                                       class="form-control @error('jumlah_bayar') is-invalid @enderror" 
                                       value="{{ old('jumlah_bayar', $reservasi->total_harga) }}"
                                       placeholder="Masukkan jumlah pembayaran"
                                       readonly>
                                @error('jumlah_bayar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Detail Pesanan</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservasi->menus as $menu)
                                    <tr>
                                        <td>{{ $menu->nama_menu }}</td>
                                        <td>{{ $menu->pivot->jumlah_pesanan }}</td>
                                        <td>Rp. {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($menu->harga * $menu->pivot->jumlah_pesanan, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                                        <td class="text-primary">
                                            <strong>Rp. {{ number_format($reservasi->total_harga, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Tampilkan/sembunyikan field kartu kredit
        $('#payment_method').change(function() {
            if ($(this).val() === 'kartu_kredit') {
                $('#kartu_kredit_fields').show();
            } else {
                $('#kartu_kredit_fields').hide();
            }
        });

        // Nonaktifkan tombol submit setelah diklik
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true);
        });

        // Validasi input nomor kartu
        $('#nomor_kartu').on('input', function() {
            // Hanya izinkan input angka
            $(this).val($(this).val().replace(/[^\d]/g, ''));
        });
    });
</script>
@endpush