@extends('layouts.admin_landing.app')

@section('content')
<div class="container mt-5">
    <div class="card list-meja-card">
        <div class="container">
            <h1 class="mt-5">List Meja</h1>

            <!-- Form Pencarian dan Filter -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari Meja" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="sort_by" class="form-control">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="nomor_meja" {{ request('sort_by') == 'nomor_meja' ? 'selected' : '' }}>Nomor Meja</option>
                            <option value="kapasitas" {{ request('sort_by') == 'kapasitas' ? 'selected' : '' }}>Kapasitas</option>
                        </select>
                        <select name="sort_order" class="form-control mt-2">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Cari</button>
            </form>

            <!-- Tombol Tambah Meja -->
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-primary btn-md" onclick="location.href='{{ route('admin.meja.create') }}'">
                    <i class="bi bi-plus"></i> Tambah Meja
                </button>
            </div>
        </div>
    </div>

    <!-- Menampilkan Pesan -->
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <!-- Menampilkan Meja dalam Format Grid -->
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($meja as $item)
                <div class="col">
                    <div class="card meja-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Meja {{ $item->nomor_meja }}</h5>
                                <p class="card-text text-muted">Lokasi: {{ $item->location->name }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Kapasitas: {{ $item->kapasitas }}</p>
                                <p class="card-text text-muted">Lantai: {{ $item->location->floor }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <div>
                                    <a href="{{ route('admin.meja.edit', $item->id) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Tidak ada meja ditemukan.</div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $meja->links() }}
    </div>
</div>

<style>
    /* Styling khusus untuk kartu utama */
    .list-meja-card {
        border-radius: 25px 25px 10px 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        transform: none !important; /* Pastikan tidak terpengaruh transform */
        transition: none !important; /* Hindari efek hover */
    }

    /* Styling untuk kartu dalam grid */
    .meja-card {
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #f9f9f9; /* Warna latar untuk kartu grid */
    }

    .meja-card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Styling tambahan untuk tata letak grid */
    .row-cols-1 {
        margin: 0 -15px;
    }
    .col {
        padding: 15px;
    }
</style>
@endsection