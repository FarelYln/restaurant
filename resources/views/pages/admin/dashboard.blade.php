@extends('layouts.admin_landing.app')
@section('content')
    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-line fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Jumlah User</p>
                <h6 class="mb-0">{{ \App\Models\User::count() }}</h6> <!-- Mengambil jumlah User -->
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-bar fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Jumlah Menu</p>
                <h6 class="mb-0">{{ \App\Models\Menu::count() }}</h6> <!-- Mengambil jumlah Menu -->
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-area fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Jumlah Reservasi</p>
                <h6 class="mb-0">{{ \App\Models\Reservasi::count() }}</h6> <!-- Mengambil jumlah Reservasi -->
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-pie fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Jumlah Meja</p>
                <h6 class="mb-0">{{ \App\Models\Meja::count() }}</h6> <!-- Mengambil jumlah Meja -->
            </div>
        </div>
    </div>
</div>

</div>

    <!-- Sale & Revenue End -->
     <!-- chart -->

     <div class="container mt-5">
    <form method="GET" action="{{ route('dashboard') }}">
        <div class="row align-items-center">
            
            <!-- Pilih Tahun -->
            <div class="col-md-4">
                <label for="year" class="form-label">Pilih Tahun</label>
                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                    @php
                        $currentYear = date('Y');
                        $years = range($currentYear - 5, $currentYear + 5); // Tampilkan tahun 5 tahun terakhir dan 5 tahun mendatang
                    @endphp
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Bulan -->
            <div class="col-md-4">
                <label for="month" class="form-label">Pilih Bulan</label>
                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                    @php
                        $bulanIndonesia = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
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
                <div class="col-md-8">
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
                <!-- Display card when there is no data -->
                <div class="col-md-8">
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
        <div class="col-md-8">
            @if($reservations->isEmpty())
                <!-- Display Empty Chart when no data -->
                <canvas id="reservasiChart" width="400" height="200"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
                    const data = [0, 0, 0, 0];  // Empty data for no reservations

                    const ctx = document.getElementById('reservasiChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar', // Use a bar chart
                        data: {
                            labels: labels, // All weeks from week 1 to 4
                            datasets: [{
                                label: 'Jumlah Reservasi',
                                data: data, // Empty data
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color of bars
                                borderColor: 'rgb(75, 192, 192)', // Border color of bars
                                borderWidth: 1, // Border width
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Minggu'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah Reservasi'
                                    },
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                }
                            }
                        }
                    });
                </script>
            @else
                <!-- Normal chart when there is data -->
                <canvas id="reservasiChart" width="400" height="200"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const allWeeks = Array.from({ length: 4 }, (_, i) => i + 1); // List of weeks from 1 to 4 (or as needed)
                    const dataWeeks = @json($reservations->pluck('week'));
                    const dataCounts = @json($reservations->pluck('count'));

                    const dataMap = Object.fromEntries(dataWeeks.map((week, index) => [week, dataCounts[index]]));
                    const labels = allWeeks.map(week => `Minggu ${week}`);
                    const weekData = allWeeks.map(week => dataMap[week] || 0); // Fill with 0 if data is missing

                    const ctx = document.getElementById('reservasiChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels, 
                            datasets: [{
                                label: 'Jumlah Reservasi',
                                data: weekData, // Data with weeks without reservations
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar background color
                                borderColor: 'rgb(75, 192, 192)', // Bar border color
                                borderWidth: 1, 
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Minggu'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah Reservasi'
                                    },
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                }
                            }
                        }
                    });
                </script>
            @endif
        </div>
    </div>
</div>




    
    <!-- Sales Chart Start -->
    <!-- Sales Chart End -->




    </div>
    <!-- Content End -->
@endsection
