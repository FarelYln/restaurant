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

    @if($reservasiData->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Tidak ada reservasi yang memiliki status confirmed.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($reservasiData as $reservasi)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">ID Reservasi: {{ $reservasi->id_reservasi }}</h5>
                            <span class="badge 
                                {{ $reservasi->status_reservasi == 'confirmed' ? 'bg-success' : 
                                   ($reservasi->status_reservasi == 'completed' ? 'bg-primary' : 'bg-warning') }}">
                            dikonfirmasi
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Informasi Pelanggan</strong>
                                <p class="mb-1">Nama: {{ $reservasi->user->name }}</p>
                                <p class="mb-1">Email: {{ $reservasi->user->email }}</p>
                            </div>
                        
                            <div class="mb-3">
                                <strong>Detail Reservasi</strong>
                                <p class="mb-1">Tanggal: {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
                                <p class="mb-1">Metode Pembayaran: {{ str_replace('_', ' ', $reservasi->metode_pembayaran) }}</p>
                                <p class="mb-1">Media: {{ $reservasi->media_pembayaran }} ({{ $reservasi->nomor_media }})</p>
                                <p class="mb-1">Status Pembayaran: {{ $reservasi->status_pembayaran }}</p>
                            </div>
                        
                            <div class="mb-3">
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
                            
                            <div class="mb-3">
                                <strong>Pesanan</strong>
                                @foreach($reservasi->menus as $menu)
                                    <p class="mb-1">
                                        {{ $menu->nama_menu }} 
                                        <span class="text-muted">(x{{ $menu->pivot->jumlah_pesanan }})</span>
                                    </p>
                                @endforeach
                            </div>
                        
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Total Harga</strong>
                                    <h5 class="text-primary mb-0">
                                        Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                                            return $menu->pivot->jumlah_pesanan * $menu->harga;
                                        }), 0, ',', '.') }}
                                    </h5>
                                </div>
                                <div>
                                    <strong>Total Bayar</strong>
                                    <h5 class="text-primary mb-0">
                                        Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                        
                            @if($reservasi->status_reservasi == 'confirmed')
                                <div class="text-center mt-3">
                                    <form action="{{ route('admin.reservasi.checkout', $reservasi->id) }}" method="GET" class="checkout-form">
                                        <button type="submit" class="btn btn-primary checkout">Selesai</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-4">
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

<script>
    document.querySelectorAll('.checkout-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Reservasi ini akan di-selesai!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>
@endsection