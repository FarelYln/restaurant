@extends('layouts.admin_landing.app')
@section('content')
    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('account.index') }}" class="bg-light rounded d-flex align-items-center justify-content-between p-4 text-decoration-none">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Jumlah User</p>
                        <h6 class="mb-0">{{ \App\Models\User::count() }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('admin.menu.index') }}" class="bg-light rounded d-flex align-items-center justify-content-between p-4 text-decoration-none">
                    <i class="fa fa-utensils fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Jumlah Menu</p>
                        <h6 class="mb-0">{{ \App\Models\Menu::count() }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('admin.reservasi.index') }}" class="bg-light rounded d-flex align-items-center justify-content-between p-4 text-decoration-none">
                    <i class="fa fa-book fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Jumlah Reservasi</p>
                        <h6 class="mb-0">
                            {{ \App\Models\Reservasi::whereIn('status_reservasi', ['confirmed', 'completed'])->count() }}
                        </h6>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('admin.meja.index') }}" class="bg-light rounded d-flex align-items-center justify-content-between p-4 text-decoration-none">
                    <i class="fa fa-table fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Jumlah Meja</p>
                        <h6 class="mb-0">{{ \App\Models\Meja::count() }}</h6>
                    </div>
                </a>
            </div>
        </div>
        
    </div>
    <!-- Sale & Revenue End -->

    <!-- Chart Section Start -->
    <div class="container mt-5">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="row align-items-center">
                <!-- Pilih Tahun -->
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Pilih Tahun</label>
                    <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear - 5, $currentYear + 5); 
                        @endphp
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Bulan -->
                <div class="col-md-6 mb-3">
                    <label for="month" class="form-label">Pilih Bulan</label>
                    <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                        @php
                            $bulanIndonesia = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 
                                6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 
                                11 => 'November', 12 => 'Desember',
                            ];
                        @endphp
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ $bulanIndonesia[$i] }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Total Pemasukan -->
                @if(!$reservations->isEmpty())
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Total Pemasukan Bulan Ini</h5>
                                <p class="card-text fs-5 fw-bold text-success">
                                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Tidak ada data masukan untuk bulan ini.</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>

        <div class="row">
            <div class="col-md-12" style="height: 100vh;">
                @if($reservations->isEmpty())
                    <!-- Display Empty Chart when no data -->
                    <canvas id="reservasiChart" style="height: 100%;"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
                        const data = [0, 0, 0, 0];

                        const ctx = document.getElementById('reservasiChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Reservasi',
                                    data: data,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: { display: true, text: 'Minggu' }
                                    },
                                    y: {
                                        title: { display: true, text: 'Jumlah Reservasi' },
                                        beginAtZero: true
                                    }
                                },
                                plugins: { legend: { display: true, position: 'top' } }
                            }
                        });
                    </script>
                @else
                    <!-- Normal chart when there is data -->
                    <canvas id="reservasiChart" style="height: 100%;"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const allWeeks = Array.from({ length: 4 }, (_, i) => i + 1);
                        const dataWeeks = @json($reservations->pluck('week'));
                        const dataCounts = @json($reservations->pluck('count'));

                        const dataMap = Object.fromEntries(dataWeeks.map((week, index) => [week, dataCounts[index]]));
                        const labels = allWeeks.map(week => `Minggu ${week}`);
                        const weekData = allWeeks.map(week => dataMap[week] || 0);

                        const ctx = document.getElementById('reservasiChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Reservasi',
                                    data: weekData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: { display: true, text: 'Minggu' }
                                    },
                                    y: {
                                        title: { display: true, text: 'Jumlah Reservasi' },
                                        beginAtZero: true
                                    }
                                },
                                plugins: { legend: { display: true, position: 'top' } }
                            }
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
    <!-- Chart Section End -->
@endsection
