@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <h1>Daftar Reservasi Pelanggan</h1>
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
    @if($reservasiData->isEmpty())
        <p style="text-align: center">Tidak ada reservasi yang memiliki status confirmed atau completed.</p>
    @else
        <div class="row">
            @foreach($reservasiData as $reservasi)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reservasi {{ $loop->iteration }}</h5>
                            <p class="card-text">Nama Pelanggan: {{ $reservasi->user->name }}</p>
                            <p class="card-text">Gmail Pelanggan: {{ $reservasi->user->email }}</p>
                            <p class="card-text">Tanggal Reservasi: {{ $reservasi->tanggal_reservasi->format('d m Y H:i') }}</p>
                            <p class="card-text">Status Reservasi: {{ ucfirst($reservasi->status_reservasi) }}</p>
                            <p class="card-text">Meja:
                                @foreach($reservasi->meja as $meja)
                                    {{ $meja->nomor_meja }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                            <p class="card-text">Menu Pesanan:
                                @foreach($reservasi->menus as $menu)
                                    {{ $menu->nama_menu }} (Jumlah: {{ $menu->pivot->jumlah_pesanan }})<br>
                                @endforeach
                            </p>
                            <p class="card-text">Total Harga: Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                                return $menu->pivot->jumlah_pesanan * $menu->harga;
                            }), 0, ',', '.') }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content">
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
<style>
    .pagination {
        justify-content: center;
    }

    .pagination .page-item {
        margin : 0 2px;
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

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .card {
        margin-top: 20px; /* Adjust margin as needed */
    }
</style>

@endsection