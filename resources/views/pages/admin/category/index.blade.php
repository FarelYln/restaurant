@extends('layouts.admin_landing.app')

@section('content')
    <div class="container mt-5">
        <div class="card" style="border-radius: 25px 25px 10px 10px;">
            <div class="container">
                <h1 class="mt-5"> List Kategori</h1>

                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex justify-content-start mb-4" style="margin-top: 30px;">
                        <!-- Form pencarian di kiri -->
                        <form method="GET" action="{{ route('admin.category.index') }}" class="d-flex"
                            style="position: absolute; bottom: 10px; left: 10px; width: auto;">
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="text" class="form-control" name="search"
                                    placeholder="Cari Berdasarkan Nama" value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#addCategoryModal"
                            style="position: absolute; bottom: 10px; right: 10px;">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Container -->
        <div class="container mt-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle mb-5">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">Nama Kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr class="border-bottom">
                                        <td class="pc-4 text-center text-muted">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $category->nama_kategori }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning" data-toggle="modal"
                                                data-target="#editCategoryModal" data-id="{{ $category->id }}"
                                                data-name="{{ $category->nama_kategori }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('admin.category.destroy', $category->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-button"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->nama_kategori }}">
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
    <div class="modal fade @if ($errors->any()) show @endif" id="addCategoryModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                id="category_name" name="nama_kategori" required value="{{ old('nama_kategori') }}">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_category_name">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_category_name" name="nama_kategori"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CDN Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert for delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus kategori: ${this.getAttribute('data-name')}`,
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

        // Populate Edit Modal
        document.querySelectorAll('[data-target="#editCategoryModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                document.getElementById('edit_category_name').value = name;
                document.getElementById('editCategoryForm').action = `/admin/category/${id}`;
            });
        });
    </script>
@endsection
