@extends('layouts.landing_page.app')

@section('content')
    <div class="container">
        <style>
            .payment-logos img {
                width: 80px;
                /* Menyusun ukuran gambar agar seragam */
                height: auto;
                /* Menjaga rasio aspek gambar */
                margin-right: 10px;
                /* Menambahkan jarak antar gambar */
            }

            .payment-logos img {
                width: 20%;
                /* Lebar gambar 20% dari kontainer .payment-logos */
                height: auto;
                /* Menjaga rasio aspek gambar */
                margin-right: 10px;
                /* Menambahkan jarak antar gambar */
            }
        </style>
        <h1 class="mb-4 text-center">Pembayaran</h1>
        <div class="card mb-4 shadow mt-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Pembayaran</h4>
            </div>

            @if ($errors->has('payment'))
                <div class="alert alert-danger mt-3">
                    {{ $errors->first('payment') }}
                </div>
            @endif

            <div class="card-body">
                {{-- Menampilkan Menu yang Dipesan --}}
                <h4 class="mb-4 text-dark" style="font-weight: bold; font-size: 16px;">Pesanan Menu</h4>
                <table class="table table-bordered table-sm" style="font-size: 15px; text-align: left;">
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
                        @foreach ($reservasiData->menus as $menu)
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

                {{-- Total Pembayaran --}}
                <div class="payment-total text-center mb-4" style="font-family: 'Arial', sans-serif; font-size: 20px;">
                    <h2 style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold;">Total Pembayaran</h2>
                    <h3 class="text-primary" style="font-family: 'Arial', sans-serif; font-size: 22px;">Rp
                        {{ number_format($totalPrice, 0, ',', '.') }}</h3>
                </div>

                {{-- Pilihan Metode Pembayaran --}}
                <div class="payment-methods" style="font-family: 'Arial', sans-serif;">
                    <h4 class="mb-3" style="font-family: 'Arial', sans-serif; font-size: 20px;">Pilih Metode Pembayaran
                    </h4>
                    <div class="row">
                        {{-- E-Wallet --}}
                        <div class="col-md-6 mb-3">
                            <div class="payment-method-card" data-method="e-wallet"
                                style="font-family: 'Arial', sans-serif;">
                                <h5 style="font-family: 'Arial', sans-serif; font-size: 18px;">E-Wallet</h5>
                                <div class="payment-logos">
                                    <img src="{{ asset('asset_landing/img/gopay-logo.png') }}" alt="GoPay">
                                    <img src="{{ asset('asset_landing/img/dana-logo.png') }}" alt="Dana">
                                    <img style="width: 40px" src="{{ asset('asset_landing/img/ovo-logo.png') }}"
                                        alt="OVO">
                                    <img src="{{ asset('asset_landing/img/shopee-logo.png') }}" alt="ShopeePay">
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Kredit --}}
                        <div class="col-md-6 mb-3">
                            <div class="payment-method-card" data-method="credit-card"
                                style="font-family: 'Arial', sans-serif;">
                                <h5 style="font-family: 'Arial', sans-serif; font-size: 18px;">Kartu Kredit</h5>
                                <div class="payment-logos">
                                    <img src="{{ asset('asset_landing/img/visa-logo.png') }}" alt="Visa">
                                    <img src="{{ asset('asset_landing/img/mastercard-logo.png') }}" alt="Mastercard">
                                    <img src="{{ asset('asset_landing/img/bca-logo.png') }}" alt="BCA">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Pembayaran --}}
                <form id="paymentForm" action="{{ route('user.reservasi.confirm', ['id' => $reservasiData->id]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                    <input type="hidden" name="payment_method" id="selectedPaymentMethod">
                    <style>
                        .form-check-label img {
                            width: 40px;
                            height: auto;
                        }

                        .form-check-label img[src*="ovo-logo"] {
                            width: 30px;
                        }
                    </style>
                    {{-- E-Wallet Section --}}
                    <div id="e-wallet-section" class="payment-detail-section" style="display:none;">
                        <h4>Pilih Provider E-Wallet</h4>
                        <div class="row">
                            @php
                                $eWalletProviders = [
                                    'gopay' => '',
                                    'dana' => '',
                                    'ovo' => '',
                                    'shopee' => '',
                                ];
                            @endphp
                            @foreach ($eWalletProviders as $code => $name)
                                <div class="col-md-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="e_wallet_provider"
                                            id="{{ $code }}" value="{{ $code }}"
                                            {{ old('e_wallet_provider') == $code ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $code }}">
                                            <img src="{{ asset('asset_landing/img/' . $code . '-logo.png') }}">
                                            {{ $name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="e_wallet_number" class="form-control"
                                placeholder="Masukkan nomor telepon terdaftar" value="{{ old('e_wallet_number') }}">
                            @error('e_wallet_number')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Kartu Kredit Section --}}
                    <div id="credit-card-section" class="payment-detail-section" style="display:none;">
                        <h4>Detail Kartu Kredit</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tipe Kartu</label>
                                <select name="credit_card_type" class="form-control">
                                    <option value="visa" {{ old('credit_card_type') == 'visa' ? 'selected' : '' }}>Visa
                                    </option>
                                    <option value="mastercard"
                                        {{ old('credit_card_type') == 'mastercard' ? 'selected' : '' }}>
                                        Mastercard</option>
                                    <option value="bca" {{ old('credit_card_type') == 'bca' ? 'selected' : '' }}>BCA
                                    </option>
                                </select>
                                @error('credit_card_type')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Pemegang Kartu</label>
                                <input type="text" name="card_holder_name" class="form-control"
                                    placeholder="Nama sesuai kartu" value="{{ old('card_holder_name') }}">
                                @error('card_holder_name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Nomor Kartu</label>
                            <input type="text" name="card_number" class="form-control"
                                placeholder="xxxx xxxx xxxx xxxx" maxlength="19" value="{{ old('card_number') }}">
                            @error('card_number')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodCards = document.querySelectorAll('.payment-method-card');
            const paymentDetailSections = document.querySelectorAll('.payment-detail-section');
            const selectedPaymentMethodInput = document.getElementById('selectedPaymentMethod');

            paymentMethodCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Reset active state
                    paymentMethodCards.forEach(c => c.classList.remove('active'));
                    paymentDetailSections.forEach(s => s.style.display = 'none');

                    // Set current method active
                    this.classList.add('active');
                    const method = this.dataset.method;

                    // Hide all sections first before showing the relevant one
                    if (method === 'e-wallet') {
                        document.getElementById('e-wallet-section').style.display = 'block';
                        selectedPaymentMethodInput.value = 'e_wallet';
                    } else if (method === 'credit-card') {
                        document.getElementById('credit-card-section').style.display = 'block';
                        selectedPaymentMethodInput.value =
                            'kartu_kredit'; // Make sure this is set to 'kartu_kredit'
                    }
                });
            });
        });
    </script>
@endpush
