@extends('layouts.landing_page.app')

@section('content')
    <!-- Hero Section -->
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 fw-bold animated slideInDown" style="font-family: 'Poppins', sans-serif;">Reservasi</h1>
            <p class="text-white-50 mb-4" style="font-family: 'Roboto', sans-serif;">
                Kelola dan lihat reservasi restoran kami dengan mudah.
            </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Reservasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Reservasi Section -->
    <div class="container py-5">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body bg-light rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="text-primary mb-0" style="font-family: 'Poppins', sans-serif;">Informasi Reservasi</h4>
                        <p class="text-muted small" style="font-family: 'Roboto', sans-serif;">Lihat detail reservasi Anda dengan mudah</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('user.reservasi.create') }}" 
                           class="btn shadow-sm text-white" 
                           style="font-family: 'Poppins', sans-serif; background: linear-gradient(90deg, #007bff, #6610f2); border: none; border-radius: 25px; padding: 10px 20px;">
                            <i class="fas fa-plus"></i> Buat Reservasi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if ($reservasiData->isEmpty())
            <div class="alert alert-warning text-center" role="alert" style="font-family: 'Roboto', sans-serif;">
                Tidak ada reservasi yang tersedia.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded-3">
                    <thead class="table" style="color: #000; font-family: 'Poppins', sans-serif;">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Status Reservasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservasiData as $reservasi)
                            <tr class="align-middle">
                                <td class="py-3" style="font-family: 'Roboto', sans-serif;">{{ $loop->iteration }}</td>
                                <td class="py-3">
                                    <span class="badge {{ $reservasi->status_reservasi === 'confirmed' ? 'bg-success' : ($reservasi->status_reservasi === 'completed' ? 'bg-primary' : 'bg-secondary') }}">
                                        {{ ucfirst($reservasi->status_reservasi) }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('user.reservasi.nota', $reservasi->id) }}" 
                                       class="btn btn-info btn-sm shadow-sm" 
                                       style="font-family: 'Poppins', sans-serif; border-radius: 25px; padding: 5px 15px;">
                                        <i class="fas fa-eye"></i> Detail
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
