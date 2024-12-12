@extends('layouts.admin_landing.app')

@section('content')
<div class="container-fluid">
    <br>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Lokasi</h6>
            <a href="{{ route('admin.location.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Lokasi
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Form Pencarian dan Sort -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari Lokasi" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="sort_by" class="form-control">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama Lokasi</option>
                            <option value="floor" {{ request('sort_by') == 'floor' ? 'selected' : '' }}>Lantai</option>
                        </select>
                        <select name="sort_order" class="form-control mt-2">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary mt-3">Cari</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Lantai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->floor }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.location.edit', $location) }}" 
                                           class="btn btn-warning btn-sm mr-1">
                                            <i class="fas fa-edit"></i> 
                                        </a>
                                        <form action="{{ route('admin.location.destroy', $location) }}" 
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm delete-btn">
                                                <i class ="fas fa-trash"></i> 
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
</div>
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

<div class="mt-3">
    <nav  aria-label="Page navigation">
        <ul class="pagination justify-content">
            <!-- Previous Button -->
            <li class="page-item {{ $locations->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $locations->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <!-- Page Numbers -->
            @foreach ($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
                <li class="page-item {{ $locations->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">{{ $page }}</a>
                </li>
            @endforeach
            <!-- Next Button -->
            <li class="page-item {{ $locations->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $locations->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('.delete-form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush