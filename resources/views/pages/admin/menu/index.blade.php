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
    padding: 10px 20px;
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

/* Menu Grid */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Tiga kolom untuk tampilan standar */
    gap: 10 px; /* Kurangi jarak antar kartu */
    margin-top: 20px;
}

/* Card Style */
.card {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    text-align: center;
    padding: 10px 5px; /* Kurangi padding samping */
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%; /* Sesuaikan lebar kartu */
    max-width: 300px; /* Batasan lebar maksimum */
    margin: 0; /* Hapus margin untuk menghindari jarak tambahan */
}
.card:hover {
    transform: translateY(-5px);
}

.card-img {
    width: 100%;
    height: 170px; /* Sesuaikan tinggi gambar */
    object-fit: cover;
    margin: 5px auto; /* Kurangi margin */
    border-radius: 8px;
}

.card-body {
    padding: 5px; /* Kurangi padding */
}

.card-title {
    font-size: 1rem; /* Kurangi ukuran font */
    font-weight: bold;
    color: #333;
}

.card-price {
    font-size: 0.9rem; /* Kurangi ukuran font */
    color: #666;
    margin: 5px 0; /* Kurangi margin */
}

.card-categories {
    margin-top: 5px; /* Kurangi margin */
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.badge {
    display: inline-block;
    background-color: #e0f7fa;
    color: #007bff;
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 3px;
    margin: 2px 0;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 5px; /* Kurangi padding */
    background-color: #f9f9f9;
    border-top: 1px solid #eee;
    gap: 5px; /* Kurangi jarak antar elemen */
}

.btn-edit {
    color: #ffc107;
    background: none;
    font-weight: bold;
    border: 1px solid #ffc107;
    padding: 5px 10px;
    border-radius: 5px;
}

.btn-edit:hover {
    background-color: #ffc107;
    color: #fff;
}

.btn-delete {
    color: #dc3545;
    background: none;
    font-weight: bold;
    border: 1px solid #dc3545;
    padding: 5px 10px;
    border-radius: 5px;
}

.btn-delete:hover {
    background-color: #dc3545;
    color: #fff;
}

.no-menu {
    text-align: center;
    font-size: 1.2rem;
    color: #666;
}

</style>
<style>
    .form-inline {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.form-control {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>
<div class="container">
    <!-- Header Card -->
    <div class="header-card">
        <div class="header">
            <h1 class="title">List Menu</h1>
            <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">Add New Menu</a>
        </div>
        <form method="GET" action="{{ route('admin.menu.index') }}" class="form-inline">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="form-control">
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" class="form-control">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" class="form-control">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <!-- Menu Grid -->
    <div class="menu-grid">
        @forelse($menus as $index => $menu)
        <div class="card">
            <a href="{{ route('admin.menu.show', $menu->id) }}">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="card-img">
            </a>
            <div class="card-body">
                <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                <p class="card-price">Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
                <div class="card-categories">
                    @foreach($menu->categories as $category)
                        <span class="badge">{{ $category->nama_kategori }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-edit">Edit</a>
                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">Delete</button>
                </form>
            </div>
        </div>
        @empty
            <p class="no-menu">No menu found</p>
        @endforelse
    </div>
    <!-- Paginasi -->
    <div class="pagination">
        {{ $menus->links() }}
    </div>
</div>
@endsection


