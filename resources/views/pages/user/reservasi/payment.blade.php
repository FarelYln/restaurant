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
                    @if($reservasi->total_harga == 0)
                        <div class="alert alert-success text-center">
                            <h5>Reservasi Gratis</h5>
                            <p>Reservasi ini tidak memerlukan pembayaran.</p>
                            <form action="{{ route('user.reservasi.payment.process', $reservasi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Konfirmasi Reservasi Gratis
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Detail Reservasi</h5>
                                <p><strong>Total Pembayaran:</strong> Rp. {{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <form id="paymentForm" action="{{ route('user.reservasi.payment.process', $reservasi->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Pilih Metode Pembayaran</label>
                                <div class="payment-methods row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card payment-method" data-method="ewallet">
                                            <div class="card-body text-center">
                                                <i class="fas fa-mobile-alt fa-2x"></i>
                                                <h6 class="mt-2">E-Wallet</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card payment-method" data-method="transfer_bank">
                                            <div class="card-body text-center">
                                                <i class="fas fa-university fa-2x"></i>
                                                <h6 class="mt-2">Transfer Bank</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card payment-method" data-method="kartu_kredit">
                                            <div class="card-body text-center">
                                                <i class="fas fa-credit-card fa-2x"></i>
                                                <h6 class="mt-2">Kartu Kredit</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_method" id="selected_payment_method">
                            </div>

                            <!-- E-Wallet Provider Selection -->
                            <div id="ewallet-providers" class="payment-provider-section" style="display:none;">
                                <h5>Pilih Provider E-Wallet</h5>
                                <div class="row">
                                    @php
                                    $ewalletProviders = [
                                        ['name' => 'gopay', 'logo' => 'gopay.png', 'title' => 'GoPay'],
                                        ['name' => 'dana', 'logo' => 'dana.png', 'title' => 'Dana'],
                                        ['name' => 'ovo', 'logo' => 'ovo.png', 'title' => 'OVO']
                                    ];
                                    @endphp
                                    @foreach($ewalletProviders as $provider)
                                    <div class="col-md-4 mb-3">
                                        <div class="card ewallet-provider" data-provider="{{ $provider['name'] }}">
                                            <div class="card-body text-center">
                                                <img src="{{ asset('images/providers/' . $provider['logo']) }}" 
                                                     alt="{{ $provider['title'] }}" 
                                                     class="img-fluid mb-2" 
                                                     style="max-height: 50px;">
                                                <h6>{{ $provider['title'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="ewallet_provider" id="selected_ewallet_provider">
                            </div>

                            <!-- Bank Provider Selection -->
                            <div id="bank-providers" class="payment-provider-section" style="display:none;">
                                <h5>Pilih Bank</h5>
                                <div class="row">
                                    @php
                                    $bankProviders = [
                                        ['name' => 'bca', 'logo' => 'bca.png', 'title' => 'BCA'],
                                        ['name' => 'mandiri', 'logo' => 'mandiri.png', 'title' => 'Mandiri'],
                                        ['name' => 'bni', 'logo' => 'bni.png', 'title' => 'BNI'],
                                        ['name' => 'bri', 'logo' => 'bri.png', 'title' => 'BRI']
                                    ];
                                    @endphp
                                    @foreach($bankProviders as $bank)
                                    <div class="col-md-3 mb-3">
                                        <div class="card bank-provider" data-bank="{{ $bank['name'] }}">
                                            <div class="card-body text-center">
                                                <img src="{{ asset('images/providers/' . $bank['logo']) }}" 
                                                     alt="{{ $bank['title'] }}" 
                                                     class="img-fluid mb-2" 
                                                     style="max-height: 50px;">
                                                <h6>{{ $bank['title'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="bank_provider" id="selected_bank_provider">
                            </div>

                            <!-- Payment Details -->
                            <div id="payment-details" style="display:none;">
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="nomor_pembayaran" class="form-label">Nomor Pembayaran</label>
                                            <input type="text" 
                                                   name="nomor_pembayaran" 
                                                   id="nomor_pembayaran" 
                                                   class="form-control" 
                                                   placeholder="Masukkan nomor pembayaran"
                                                   required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="total_bayar" class="form-label">Total Pembayaran</label>
                                            <input type="number" 
                                                   name="total_bayar" 
                                                   id="total_bayar" 
                                                   class="form-control" 
                                                   value="{{ $reservasi->total_harga }}"
                                                   readonly>
                                        </ ```php
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success" id="submit_button" style="display:none;">
                                    Proses Pembayaran
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.payment-method').forEach(function(methodCard) {
        methodCard.addEventListener('click', function() {
            const selectedMethod = this.getAttribute('data-method');
            document.getElementById('selected_payment_method').value = selectedMethod;

            // Reset and hide all provider sections
            document.querySelectorAll('.payment-provider-section').forEach(function(section) {
                section.style.display = 'none';
            });
            document.getElementById('payment-details').style.display = 'none';
            document.getElementById('submit_button').style.display = 'none';

            // Show relevant provider section
            if (selectedMethod === 'ewallet') {
                document.getElementById('ewallet-providers').style.display = 'block';
            } else if (selectedMethod === 'transfer_bank') {
                document.getElementById('bank-providers').style.display = 'block';
            }
        });
    });

    document.querySelectorAll('.ewallet-provider').forEach(function(providerCard) {
        providerCard.addEventListener('click', function() {
            const selectedProvider = this.getAttribute('data-provider');
            document.getElementById('selected_ewallet_provider').value = selectedProvider;

            // Show payment details
            document.getElementById('payment-details').style.display = 'block';
            document.getElementById('submit_button').style.display = 'block';
        });
    });

    document.querySelectorAll('.bank-provider').forEach(function(bankCard) {
        bankCard.addEventListener('click', function() {
            const selectedBank = this.getAttribute('data-bank');
            document.getElementById('selected_bank_provider').value = selectedBank;

            // Show payment details
            document.getElementById('payment-details').style.display = 'block';
            document.getElementById('submit_button').style.display = 'block';
        });
    });
</script>
@endsection