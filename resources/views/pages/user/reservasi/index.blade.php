@extends('layouts.landing_page.app')

@section('content')

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Nikmati Hidangan<br>Lezat Bersama Kami</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">
                        Selamat datang di restoran kami, tempat di mana cita rasa istimewa dan pengalaman bersantap yang
                        nyaman bersatu.
                        Pesan meja Anda sekarang dan nikmati momen yang tak terlupakan bersama orang-orang terkasih.
                    </p>
                    <a href="#reservasi-form" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Reservasi
                        Sekarang</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="{{ asset('asset_landing/img/hero.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row mb-4 align-items-center">
                <div class="col">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservasi</h5>
                    <h1 class="mb-0">Daftar Reservasi</h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('user.reservasi.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Buat Reservasi Baru
                    </a>
                </div>
            </div>

            @if ($reservasis->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Anda belum memiliki reservasi. Silakan buat reservasi baru.
                </div>
            @else
                <div class="row g-4">
                    @foreach ($reservasis as $reservasi)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm position-relative">
                                @php
                                    $remainingTime = $reservasi->remaining_time;
                                    $timerClass = 'bg-success'; // default

                                    if (strpos($remainingTime, ':') !== false) {
                                        $timeParts = explode(':', $remainingTime);
                                        $totalSeconds = $timeParts[0] * 3600 + $timeParts[1] * 60 + $timeParts[2];

                                        if ($totalSeconds <= 900) {
                                            // < 15 menit
                                            $timerClass = 'bg-danger';
                                        } elseif ($totalSeconds <= 1800) {
                                            // < 30 menit
                                            $timerClass = 'bg-warning text-dark';
                                        }
                                    }
                                @endphp

                                <div id="timer-{{ $reservasi->id }}"
                                    class="timer badge {{ $timerClass }} {{ $remainingTime == 'Expired' ? 'timer-expired' : '' }}"
                                    style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                    {{ $remainingTime }}
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0">
                                            Reservasi #{{ $reservasi->id }}
                                        </h5>
                                    </div>

                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-table text-primary me-2"></i>
                                            <span>Meja: {{ $reservasi->meja->nomor_meja }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-check text-primary me-2"></i>
                                            <span>
                                                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @switch($reservasi->status_reservasi)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @break

                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @break

                                            @case('completed')
                                                <span class="badge bg-info">Completed</span>
                                            @break

                                            @case('canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @break
                                        @endswitch
                                    </div>

                                    {{-- Daftar Menu --}}
                                    @if ($reservasi->menus->isNotEmpty())
                                        <div class="mb-3">
                                            <strong>
                                                <i class="bi bi-list-ul text-primary me-1"></i>
                                                Menu Dipesan:
                                            </strong>
                                            <ul class="list-unstyled small">
                                                @foreach ($reservasi->menus as $menu)
                                                    <li>
                                                        {{ $menu->nama_menu }}
                                                        ({{ $menu->pivot->jumlah_pesanan }} x)
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between mt-auto">
                                        @if ($reservasi->status_reservasi == 'pending')
                                            <a href="{{ route('user.reservasi.payment', $reservasi->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-credit-card me-1"></i>Bayar
                                            </a>
                                            <a href="{{ route('user.reservasi.cancel', $reservasi->id) }}"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin ingin membatalkan reservasi?')">
                                                <i class="bi bi-x-circle me-1"></i>Batalkan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($reservasis->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservasis->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTimers() {
                document.querySelectorAll('[id^="timer-"]').forEach(function(timerEl) {
                    const reservasiId = timerEl.id.replace('timer-', '');

                    // Tambahkan pencegahan auto-cancel
                    fetch(`/reservasi/${reservasiId}/prevent-auto-cancel`)
                        .then(response => response.json())
                        .then(preventData => {
                            if (preventData.status !== 'valid') return;

                            // Lanjutkan dengan pengambilan remaining time
                            return fetch(`/reservasi/${reservasiId}/remaining-time`);
                        })
                        .then(response => {
                            if (!response) return;
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;

                            timerEl.textContent = data.remaining_time;

                            // Reset class
                            timerEl.classList.remove('bg-success', 'bg-warning', 'bg-danger',
                                'text-dark', 'timer-expired');

                            if (data.remaining_time === 'Expired' || data.status !== 'pending') {
                                timerEl.classList.add('bg-danger', 'timer-expired');
                                location.reload(); // Reload halaman untuk update status
                            } else {
                                const timeParts = data.remaining_time.split(':');
                                const totalSeconds = parseInt(timeParts[0]) * 3600 +
                                    parseInt(timeParts[1]) * 60 +
                                    parseInt(timeParts[2]);

                                if (totalSeconds <= 900) { // < 15 menit
                                    timerEl.classList.add('bg-danger');
                                } else if (totalSeconds <= 1800) { // < 30 menit
                                    timerEl.classList.add('bg-warning', 'text-dark');
                                } else {
                                    timerEl.classList.add('bg-success');
                                }
                            }
                        })
                        .catch(error => console.error('Error fetching remaining time:', error));
                });
            }

            updateTimers();
            setInterval(updateTimers, 60000); // Update every minute
        });
    </script>
@endpush
