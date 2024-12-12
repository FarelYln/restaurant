@extends('layouts.landing_page.app')

@section('content')
    <!-- Hero Section -->
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Reservasi</h1>
            <p class="text-white-50 mb-4">
                Kelola dan lihat reservasi restoran kami dengan mudah.
            </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Reservasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Reservasi Section -->
    <div class="container py-5">
        <div class="card mb-4">
            <div class="card-body bg-light">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="text-primary">Informasi Reservasi</h4>
                        
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('user.reservasi.create') }}" class="btn btn-primary">Buat Reservasi Baru</a>
                    </div>
                </div>
            </div>
        </div>

        @if ($reservasiData->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada reservasi yang memiliki status <strong>Confirmed</strong> atau <strong>Completed</strong>.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table" style="background-color: rgb(245, 194, 85); color: rgb(0, 0, 0);">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Reservasi</th>
                            <th>Status Reservasi</th>
                            <th>Meja</th>
                            <th>Menu Pesanan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservasiData as $reservasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</td>
                                <td><span class="badge bg-success">{{ ucfirst($reservasi->status_reservasi) }}</span></td>
                                <td>
                                    @foreach ($reservasi->meja as $meja)
                                        <span class="badge bg-secondary">Meja {{ $meja->nomor_meja }}</span>
                                    @endforeach
                                </td>
                                <td class="text-start">
                                    @foreach ($reservasi->menus as $menu)
                                        <div>
                                            {{ $menu->nama_menu }}
                                            <span class="badge bg-primary">Jumlah: {{ $menu->pivot->jumlah_pesanan }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>Rp
                                    {{ number_format(
                                        $reservasi->menus->sum(function ($menu) {
                                            return $menu->pivot->jumlah_pesanan * $menu->harga;
                                        }),
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>
                                <td>
                                    <a href="{{ route('user.reservasi.nota', $reservasi->id) }}" class="btn btn-info btn-sm">
                                        Lihat Nota
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection