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
    <div class="container mt-5">
    <form method="GET" action="{{ route('dashboard') }}">
        <div class="row align-items-center">
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
            @endif
        </div>
    </form>
</div>

    </form>

    @if($reservations->isEmpty())
        <p class="text-center mt-5">Tidak ada data reservasi untuk bulan ini.</p>
    @else
        <canvas id="reservasiChart" width="400" height="200"></canvas>
        

      <!-- end chart -->
      
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
    const allWeeks = Array.from({ length: 4 }, (_, i) => i + 1); // Daftar minggu dari 1 hingga 5 (atau sesuai kebutuhan)
    const dataWeeks = @json($reservations->pluck('week'));
    const dataCounts = @json($reservations->pluck('count'));

    // Buat objek data berbasis minggu yang tersedia
    const dataMap = Object.fromEntries(dataWeeks.map((week, index) => [week, dataCounts[index]]));

    // Lengkapi data untuk semua minggu
    const labels = allWeeks.map(week => `Minggu ${week}`);
    const weekData = allWeeks.map(week => dataMap[week] || 0); // Isi 0 jika data tidak tersedia

    const ctx = document.getElementById('reservasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Menggunakan chart batang
        data: {
            labels: labels, // Semua minggu dari minggu 1 hingga 5
            datasets: [{
                label: 'Jumlah Reservasi',
                data: weekData, // Data termasuk minggu tanpa reservasi
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang batang
                borderColor: 'rgb(75, 192, 192)', // Warna border batang
                borderWidth: 1, // Ketebalan border batang
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
    const dataPemasukan = @json($reservations->pluck('total_pemasukan'));
const pemasukanData = allWeeks.map(week => dataMap[week] || 0); // Sama seperti weekData, lengkapi data pemasukan

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels, // Semua minggu dari 1 hingga 5
        datasets: [
            {
                label: 'Jumlah Reservasi',
                data: weekData, // Data reservasi
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
            },
            {
                label: 'Pemasukan (Rp)',
                data: pemasukanData, // Data pemasukan
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1,
            },
        ]
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
                    text: 'Jumlah'
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

    
    <!-- Sales Chart Start -->
    <!-- Sales Chart End -->




    </div>
    <!-- Content End -->
@endsection
