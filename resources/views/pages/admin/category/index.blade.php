@extends('layouts.admin_landing.app')

@section('content')
<!-- Tambahkan CDNs Bootstrap di bagian <head> jika belum ada -->
<head>
    <!-- CDN Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container mt-5">
    <div class="card" 
    style="border-radius: 25px 25px 10px 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="container">
    <h1 class="mt-5">-- Category List</h1>

    <div class="d-flex justify-content-between mb-4">
    <div class="d-flex justify-content-start mb-4" style="margin-top: 30px;">
    <!-- Form pencarian di kiri -->
    <form method="GET" action="{{ route('admin.category.index') }}" class="d-flex">
        <div class="input-group input-group-md" style="margin-left: 60px;">
            <input type="text" class="form-control" name="search" placeholder="Cari Berdasarkan Nama" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>


<div class="d-flex justify-content-end mb-3">
        <button class="btn btn-outline-primary btn-md mb-2" data-toggle="modal" data-target="#addCategoryModal" style="margin-right: 70px;">
        <i class="bi bi-plus"></i>
        </button>
    </div>
    </div></div>
</div>
    <!-- Menampilkan pesan success atau error -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Card Container -->
    <div class="container mt-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle mb-5">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th style=" padding-left:2%;" class="text-center">NO</th>
                            <th style="padding-left: 15%;">Nama Kategori</th>
                            <th style="padding-left: 28%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr class="border-bottom">
                                <td class="pc-4 text-center text-muted">{{ $index + 1 }}</td>
                                <td style="padding-left: 16%;">{{ $category->nama_kategori }}</td>
                                <td style="padding-left: 25%;">
                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3" data-toggle="modal" data-target="#editCategoryModal" 
                                        data-id="{{ $category->id }}" data-name="{{ $category->nama_kategori }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada kategori ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





</div>

<!-- Modal for Adding Category -->
<div class="modal fade @if ($errors->any()) show @endif" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="category_name" name="nama_kategori" required value="{{ old('nama_kategori') }}">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_category_name">Category Name</label>
                        <input type="text" class="form-control" id="edit_category_name" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CDN Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script for Handling Edit Modal -->
<script>
    $('#editCategoryModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract the category id
        var name = button.data('name'); // Extract the category name

        var modal = $(this);
        modal.find('.modal-title').text('Edit Category: ' + name);
        modal.find('#edit_category_name').val(name);
        modal.find('#editCategoryForm').attr('action', '{{ route("admin.category.update", ":id") }}'.replace(':id', id)); // Update form action with correct route
    });

    // Ensure modal stays open on validation errors
    $(document).ready(function () {
        @if ($errors->any())
            $('#addCategoryModal').modal('show');
        @endif
    });
</script>

@endsection
