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
        <!-- Header and Filter Section -->
        <div class="header-card">
            <div class="header">
                <h1 class="title">Daftar Lokasi</h1>
                <a href="{{ route('admin.location.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Lokasi
                </a>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.location.index') }}" class="mb-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari Lokasi" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="sort_by" class="form-control">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama Lokasi</option>
                            <option value="floor" {{ request('sort_by') == 'floor' ? 'selected' : '' }}>Lantai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort_order" class="form-control">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table of Locations -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-5">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">Nama Lokasi</th>
                                <th class="text-center">Lantai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr class="border-bottom">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $location->name }}</td>
                                    <td class="text-center">{{ $location->floor }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.location.edit', $location) }}" 
                                               class="btn btn-warning btn-sm" style="margin-right: 10px;">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.location.destroy', $location) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-btn" data-name="{{ $location->name }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            
                                        </div>                                                                                                                                             
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $locations->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $locations->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @foreach ($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
                        <li class="page-item {{ $locations->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $locations->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $locations->nextPageUrl() }}" aria-label="Next">
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
                text: `Anda akan menghapus lokasi: ${name}`,
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
