@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <div class="header-card">
        <h1 class="title">{{ $menu->nama_menu }}</h1>
    </div>
    <div class="card">
        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="card-img">
        <div class="card-body">
            <h5 class="card-title">{{ $menu->nama_menu }}</h5>
            <p class="card-price">Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
            <p class="card-description">{{ $menu->description }}</p>
            <div class="card-categories">
                @foreach($menu->categories as $category)
                    <span class="badge">{{ $category->nama_kategori }}</span>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-primary">Back to Menu List</a>
        </div>
    </div>
</div>
@endsection