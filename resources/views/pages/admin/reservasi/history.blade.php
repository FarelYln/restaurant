@extends('layouts.admin_landing.app')

@section('content')
        <style>
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                font-family: Arial, sans-serif;
            }

            /* Header Card */
            .header-card {
                background-color: #fff;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .header-card .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .title {
                font-size: 2rem;
                font-weight: bold;
                color: #333;
            }

            .btn {
                padding: 5px 10px;
                text-decoration: none;
                border: none;
                border-radius: 5px;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .btn-primary {
                background-color: #007bff;
                color: #fff;
            }

            .btn-primary:hover {
                background-color: #0056b3;
            }

            .form-inline {
                display: flex;
                gap: 8px;
                /* Reduced gap */
                margin-top: 10px;
            }

            .form-control {
                padding: 8px;
                /* Reduced padding */
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 0.9rem;
                /* Adjust font size */
                width: 180px;
                /* Set a fixed width */
            }

            .btn-primary {
                padding: 8px 16px;
                /* Reduced padding */
                font-size: 0.9rem;
                /* Adjust font size */
            }

            /* Card Container */
            .card-table {
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            .table th, .table td {
                text-align: center;
                vertical-align: middle;
            }

            .table-hover tbody tr:hover {
                background-color: #f9f9f9;
            }

            .modal-backdrop {
                background-color: rgba(255, 255, 255, 0.5) !important;
            }

            .modal {
                z-index: 1050 !important;
            }
        </style>

        <div class="container">
            <!-- Header Card -->
            <div class="header-card">
                <div class="header">
                    <h1 class="title">Daftar Reservasi Pelanggan</h1>
                </div>
            </div>

            <!-- Card Table -->
            <div class="card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Reservasi</th>
                                    <th>Status Reservasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasiData as $reservasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $reservasi->user->name }}</td>
                                        <td>{{ $reservasi->tanggal_reservasi->format('d M Y') }}</td>
                                        <td><span class="badge bg-warning">{{ ucfirst($reservasi->status_reservasi) }}</span></td>
                                        <td>
                                            <!-- Action Button -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $reservasi->id }}">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal for detail reservasi -->
                                    <div class="modal fade" id="detailModal{{ $reservasi->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $reservasi->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $reservasi->id }}">Detail Reservasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama Pelanggan:</strong> {{ $reservasi->user->name }}</p>
                                                    <p><strong>Email Pelanggan:</strong> {{ $reservasi->user->email }}</p>
                                                    <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
                                                    <p><strong>Status Reservasi:</strong><span class="badge bg-warning"> {{ ucfirst($reservasi->status_reservasi) }}</span></p>
                                                    <p><strong>Metode Pembayaran:</strong> {{ $reservasi->metode_pembayaran }}</strong></p>
                                                    <p><strong>Media Pembayaran:</strong> {{ $reservasi->media_pembayaran }} ({{ $reservasi->nomor_media }})</p>
                                                    <p><strong>Meja:</strong>
                                                        @foreach($reservasi->meja as $meja)
                                                            {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                                                        @endforeach
                                                    </p>
                                                    <p><strong>Menu Pesanan:</strong>
                                                        @foreach($reservasi->menus as $menu)
                                                            {{ $menu->nama_menu }} (Jumlah: {{ $menu->pivot->jumlah_pesanan }})<br>
                                                        @endforeach
                                                    </p>
                                                    <p><strong>Total Harga:</strong> Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                                                        return $menu->pivot->jumlah_pesanan * $menu->harga;
                                                    }), 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item {{ $reservasiData->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $reservasiData->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <!-- Page Numbers -->
                    @foreach ($reservasiData->getUrlRange(1, $reservasiData->lastPage()) as $page => $url)
                        <li class="page-item {{ $reservasiData->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <!-- Next Button -->
                    <li class="page-item {{ $reservasiData->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $reservasiData->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

<!-- Modal CSS adjustment: -->
<style>
    .modal-backdrop {
        background-color: rgba(255, 255, 255, 0.5) !important;
    }

    .modal {
        z-index: 1050 !important;
    }

    .modal-content {
        background-color: #fff;
    }
</style>

@endsection
