@extends('layouts.admin_landing.app')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

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
        padding: 10px 20px;
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
        gap: 10px;
        margin-top: 10px;
    }

    .form-control {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .meja-card {
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: -10px;
    }

    .meja-card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

  
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
        line-height: 1.25;
    }
</style>
<style>
.pagination {
    justify-content: center;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    border: 1px solid #ddd;
    color: #495057;
    border-radius: 5px;
}

.pagination .page-link:hover {
    background-color: #389ee2;
    color: white;
}

.pagination .page-item.active .page-link {
    background-color: #386ee2;
    border-color: #007bff;
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
}
</style>
        <div class="container">
            <!-- Header Card -->
            <div class="header-card">
                <div class="header">
                    <h1 class="title">Daftar Reservasi Pelanggan</h1>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" placeholder="Cari..." class="form-control">
                            </div>
                            
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
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
                                    <th>Id</th>
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
                                        <td>{{ $reservasi->id_reservasi }}</td>
                                        <td>{{ $reservasi->user->name }}</td>
                                        <td>{{ $reservasi->tanggal_reservasi->format('d M Y') }}</td>
                                        <td><span class="badge bg-warning">selesai</span></td>
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
                <h5 class="modal-title" id="detailModalLabel{{ $reservasi->id_reservasi }}">Detail Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Informasi Pelanggan -->
                <div class="mb-4">
                    <h6 class="fw-bold">Informasi Pelanggan</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $reservasi->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $reservasi->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Reservasi -->
                <div class="mb-4">
                    <h6 class="fw-bold">Detail Reservasi</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->id_reservasi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($reservasi->status_reservasi) }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', $reservasi->metode_pembayaran) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Media Pembayaran:</strong> {{ $reservasi->media_pembayaran }} ({{ $reservasi->nomor_media }})</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Meja -->
                <div class="mb-4">
                    <strong>Meja dan Lantai</strong>
                    <p class="mb-1">
                        @foreach($reservasi->meja as $meja)
                            Meja: {{ $meja->nomor_meja }} - 
                            Lokasi: {{ optional($meja->location)->name ?? 'Lokasi tidak tersedia' }} - 
                            Lantai: {{ optional($meja->location)->floor ?? 'Lantai tidak tersedia' }}
                            @if(!$loop->last), 
                            @endif
                        @endforeach
                    </p>
                </div>
                <!-- Menu Pesanan -->
                <div class="mb-4">
                    <h6 class="fw-bold">Menu Pesanan</h6>
                    <p>
                        @foreach($reservasi->menus as $menu)
                            {{ $menu->nama_menu }} (Jumlah: {{ $menu->pivot->jumlah_pesanan }})<br>
                        @endforeach
                    </p>
                </div>

                <!-- Total Harga -->
                <div class="mb-4">
                    <h6 class="fw-bold">Total Harga</h6>
                    <p><strong>Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                        return $menu->pivot->jumlah_pesanan * $menu->harga;
                    }), 0, ',', '.') }}</strong></p>
                </div>
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
