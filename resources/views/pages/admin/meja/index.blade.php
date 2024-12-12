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

        /* Styling for table/grid cards */
        .meja-card {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: -10px; /* Menambahkan margin-top untuk menggeser card ke atas */
        }

        .meja-card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .list-meja-card {
            border-radius: 25px 25px 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Grid layout styling */
        .row-cols-1 {
            margin: 0 -15px;
        }

        .col {
            padding: 15px;
        }

        /* Pagination Styles */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-link {
            border-radius: 50%;
            padding: 10px 15px;
            margin: 0 5px;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination .active .page-link {
            background-color: #007bff;
            color: #fff;
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

        /* Tombol kecil */
        .btn-sm {
            padding: 5px 10px; /* Ukuran tombol yang lebih kecil */
            font-size: 0.875rem; /* Ukuran font sedikit lebih kecil */
            line-height: 1.25; /* Sesuaikan dengan ukuran tombol */
        }
    </style>

    <div class="container">
        <!-- Header Card -->
        <div class="header-card">
            <div class="header">
                <h1 class="title">List Meja</h1>
                <a href="{{ route('admin.meja.create') }}" class="btn btn-primary ">
                    <i class="bi bi-plus"></i> Tambah Meja
                </a>
            </div>

            <!-- Form Pencarian dan Filter -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari Meja"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia
                            </option>
                            <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>
                                Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sort_by" class="form-control">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="nomor_meja" {{ request('sort_by') == 'nomor_meja' ? 'selected' : '' }}>Nomor Meja
                            </option>
                            <option value="kapasitas" {{ request('sort_by') == 'kapasitas' ? 'selected' : '' }}>Kapasitas
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sort_order" class="form-control">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Menampilkan Meja dalam Format Grid -->
    <div class="container">
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
                                <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} ">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <div>
                                    <a href="{{ route('admin.meja.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
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
    <div class="mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content">
                <!-- Previous Button -->
                <li class="page-item {{ $meja->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $meja->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <!-- Page Numbers -->
                @foreach ($meja->getUrlRange(1, $meja->lastPage()) as $page => $url)
                    <li class="page-item {{ $meja->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <!-- Next Button -->
                <li class="page-item {{ $meja->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $meja->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
