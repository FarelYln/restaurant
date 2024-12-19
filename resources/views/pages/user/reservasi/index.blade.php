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
            <div class="row">
                @foreach ($reservasiData as $reservasi)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 hover-shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title">Reservasi {{ $loop->iteration }} | ID: {{ $reservasi->id_reservasi }}</h5>
                                <p class="card-text">
                                    Status: 
                                    <span class="badge {{ $reservasi->status_reservasi === 'confirmed' ? 'bg-success' : ($reservasi->status_reservasi === 'completed' ? 'bg-primary' : 'bg-secondary') }}">
                                        @php
                                            // Pemetaan status ke bahasa Indonesia
                                            $statusTranslations = [
                                                'confirmed' => 'Dikonfirmasi',
                                                'completed' => 'Selesai',
                                                'pending' => 'Menunggu',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                            // Ambil terjemahan atau gunakan status asli jika tidak ada di pemetaan
                                            $statusIndo = $statusTranslations[$reservasi->status_reservasi] ?? ucfirst($reservasi->status_reservasi);
                                        @endphp
                                        {{ $statusIndo }}
                                    </span>
                                </p>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('user.reservasi.nota', $reservasi->id) }}" 
                                       class="btn btn-primary btn-sm shadow-sm" 
                                       style="font-family: 'Poppins', sans-serif; border-radius: 25px; padding: 5px 15px;">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .hover-shadow-lg {
            transition: all 0.3s ease;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
