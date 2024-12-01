@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Menu</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="imagePreview" src="{{ asset('storage/' . $menu->image) }}" alt="Preview" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_menu" class="form-label">Menu Name</label>
                <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}">
                @error('nama_menu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="harga" class="form-label">Price</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" step="0.01" value="{{ old('harga', $menu->harga) }}">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Categories</label>
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

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" style="height: 150px; overflow-y: auto;">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-success">Update</button>
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
    };

    reader.readAsDataURL(event.target.files[0]);
}
</script>
