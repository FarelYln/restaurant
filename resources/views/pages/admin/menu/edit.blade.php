@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h1 class="mb-4">Edit Menu</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card diperlebar -->
    <div class="card shadow-sm p-4 border-0 mx-auto" style="max-width: 1000px;">
        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Gambar -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-12 text-center">
                    <label for="image" class="form-label d-block mb-3">Gambar Menu</label>
                    <!-- Hidden file input field -->
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Clickable image preview -->
                    <img 
                        id="imagePreview" 
                        src="{{ asset('storage/' . $menu->image) }}" 
                        alt="Preview" 
                        style="cursor: pointer; width: 250px; height: 250px; border-radius: 10px; border: 2px solid #ddd;" 
                        onclick="document.getElementById('image').click();"
                    >
                    <p class="mt-2 text-muted">Klik gambar untuk mengganti</p>
                </div>
            </div>

            <!-- Nama Menu -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control w-100 @error('nama_menu') is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}">
                    @error('nama_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Harga -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control w-100 @error('harga') is-invalid @enderror" id="harga" name="harga" step="0.01" value="{{ old('harga', $menu->harga) }}">
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kategori -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="form-label">Kategori</label>
                    <div class="d-flex flex-wrap">
                        @foreach($categories as $category)
                            <div class="form-check me-3 mb-2">
                                <input type="checkbox" class="form-check-input" id="category{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}" 
                                    {{ in_array($category->id, $menu->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category{{ $category->id }}">{{ $category->nama_kategori }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('category_ids')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control w-100 @error('description') is-invalid @enderror" id="description" name="description" style="height: 150px;">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Update -->
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-success px-4">Perbarui</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
function previewImage(event) {
    const reader = new FileReader();
    const imagePreview = document.getElementById('imagePreview');

    reader.onload = () => {
        imagePreview.src = reader.result;
    };

    reader.readAsDataURL(event.target.files[0]);
}
</script>
