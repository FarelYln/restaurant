@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h1 class="card-title">Daftar Reservasi Pelanggan</h1>
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
            Tidak ada reservasi yang memiliki status confirmed atau completed.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($reservasiData as $reservasi)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Reservasi #{{ $loop->iteration }}</h5>
                            <span class="badge 
                                {{ $reservasi->status_reservasi == 'confirmed' ? 'bg-success' : 
                                   ($reservasi->status_reservasi == 'completed' ? 'bg-primary' : 'bg-warning') }}">
                                {{ ucfirst($reservasi->status_reservasi) }}
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
                                <p class="mb-1">Metode Pembayaran: {{ $reservasi->metode_pembayaran }}</p>
                                <p class="mb-1">Media: {{ $reservasi->media_pembayaran }} ({{ $reservasi->nomor_media }})</p>
                            </div>

                            <div class="mb-3">
                                <strong>Meja</strong>
                                <p class="mb-1">
                                    @foreach($reservasi->meja as $meja)
                                        {{ $meja->nomor_meja }}@if(!$loop->last), @endif
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

                            <div class="mt-3">
                                <strong>Total Harga</strong>
                                <h5 class="text-primary">
                                    Rp {{ number_format($reservasi->menus->sum(function ($menu) {
                                        return $menu->pivot->jumlah_pesanan * $menu->harga;
                                    }), 0, ',', '.') }}
                                </h5>
                            </div>

                            @if($reservasi->status_reservasi == 'confirmed')
                                <div class="text-center mt-3">
                                    <form action="{{ route('admin.reservasi.checkout', $reservasi->id) }}" method="GET"
                                        class="checkout-form">
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