@extends('layouts.admin_landing.app')

@section('content')
<style>
    /* Styling untuk form dan preview gambar */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    h1.mb-4 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: bold;
    }

    /* Gambar preview dalam bentuk kotak dengan ukuran 50mm x 50mm */
    .image-preview {
        display: none;
        width: 150px;
        height: 150px;
        object-fit: cover; /* Agar gambar terpotong jika lebih besar dari kotak */
        border-radius: 8px;
        margin-top: 10px;
        border: 2px solid #ddd;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.25rem;
    }

    .row.mb-3 {
        margin-bottom: 1rem;
    }

    .row.mb-3 .col-md-6 {
        margin-bottom: 1rem;
    }

    .form-check-input {
        margin-right: 8px;
    }

    .text-danger {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .text-end {
        text-align: right;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-check-label {
        font-size: 1rem;
        color: #333;
    }

    .form-control {
        padding: 10px;
        font-size: 1rem;
        border-radius: 5px;
    }

    textarea.form-control {
        resize: vertical;
    }

</style>
<div class="container">
    <h1 class="mt-4 text-center">Tambah Menu</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="image" class="form-label mt-4">Gambar</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="imagePreview" src="#" alt="Preview" class="image-preview">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_menu" class="form-label">Halaman Nama Menu</label>
                <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu') }}">
                @error('nama_menu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" step="0.01" value="{{ old('harga') }}">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Kategori</label>
                <div class="d-flex flex-wrap">
                    @foreach($categories as $category)
                        <div class="form-check me-3 mb-2">
                            <input type="checkbox" class="form-check-input" id="category{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}">
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->nama_kategori }}</label>
                        </div>
                    @endforeach
                </div>
                @error('category_ids')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" style="height: 150px; overflow-y: auto;">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </form>
</div>

@endsection

<script>
function previewImage(event) {
    const reader = new FileReader();
    const imagePreview = document.getElementById('imagePreview');

    reader.onload = () => {
        imagePreview.src = reader.result;
        imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(event.target.files[0]);
}
</script>
