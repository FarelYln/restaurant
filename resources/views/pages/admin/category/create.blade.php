@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1>Add Category</h1>
    <form action="{{ route('admin.category.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_kategori">Category Name</label>
            <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" required>
            @error('nama_kategori')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
