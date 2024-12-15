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
                <h1 class="title">List Meja</h1>
                <a href="{{ route('admin.meja.create') }}" class="btn btn-primary ">
                    <i class="bi bi-plus"></i> Tambah Meja
                </a>
            </div>

            <form method="GET" action="{{ route('admin.meja.index') }}" class="mb-4 mt-3">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari Meja" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort_by" class="form-control">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="nomor_meja" {{ request('sort_by') == 'nomor_meja' ? 'selected' : '' }}>Nomor Meja</option>
                            <option value="kapasitas" {{ request('sort_by') == 'kapasitas' ? 'selected' : '' }}>Kapasitas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort_order" class="form-control">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" class="btn btn-primary ">Filter</button>
                    </div>
                </div>
            </form>
                      
        </div>

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
                                <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} ">{{ ucfirst($item->status) }}</span>
                                <div>
                                    <a href="{{ route('admin.meja.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-name="Meja {{ $item->nomor_meja }}">
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

        <!-- Pagination -->
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $meja->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $meja->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @foreach ($meja->getUrlRange(1, $meja->lastPage()) as $page => $url)
                        <li class="page-item {{ $meja->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $meja->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $meja->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan menghapus ${name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
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
