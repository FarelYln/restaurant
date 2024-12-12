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
    </style>

    <div class="container">
        <div class="header-card">
            <h1 class="tittle">List Lokasi</h1>
            <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('admin.location.create') }}" class="btn btn-primary btn-md">
                <i class="bi bi-plus"></i> Tambah Lokasi
            </a>
        </div>
         <!-- Form Pencarian dan Sort -->
         <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari Lokasi"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="sort_by" class="form-control">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama Lokasi</option>
                        <option value="floor" {{ request('sort_by') == 'floor' ? 'selected' : '' }}>Lantai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort_order" class="form-control ">
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
        <div class="table-responsive">
            <div class="container mt-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle mb-5">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Lokasi</th>
                                        <th class="text-center">Lantai</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($locations as $index => $location)
                                        <tr class="border-bottom">
                                            <td class="pc-4 text-center text-muted">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $location->name }}</td>
                                            <td class="text-center">{{ $location->floor }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.location.edit', $location) }}" class="btn btn-warning me-2">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.location.destroy', $location) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-button">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada lokasi ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="pagination-container d-flex justify-content-center align-items-center mt-4">
                <nav aria-label="Location page navigation">
                    {{ $locations->onEachSide(1)->links('pagination::bootstrap-4', ['paginator' => $locations]) }}
                </nav>
           </div>
        </div>
      </div>
    </div>
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
