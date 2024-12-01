@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Menu List</h1>
    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary mb-4">Add New Menu</a>

    <div class="row">
        @forelse($menus as $menu)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                    <p class="card-text">Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
                    <div>
                        @foreach($menu->categories as $category)
                            <span class="badge bg-info">{{ $category->nama_kategori }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No menu found</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
