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
            grid-template-columns: repeat(3, 1fr);
            /* Tiga kolom untuk tampilan standar */
            gap: 20px;
            margin-top: 20px;
        }

        /* Menampilkan postingan ke-4 dan seterusnya di bawah */
        .menu-grid>.card:nth-child(n+4) {
            grid-column: span 1;
            /* Elemen ke-4 dan seterusnya tetap di baris kedua */
        }

        /* Card Style */
        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin: 10px auto;
            border-radius: 8px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .card-price {
            font-size: 1rem;
            color: #666;
            margin: 10px 0;
        }

        .card-categories {
            margin-top: 10px;
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
            padding: 10px 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            gap: 10px;
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
                <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Menu
                </a>
            </div>
            <form method="GET" action="{{ route('admin.menu.index') }}" class="form-inline">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Berdasarkan Nama..."
                    class="form-control">
                <select name="category_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga Minimal"
                    class="form-control">
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga Maksimal"
                    class="form-control">
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
                            @foreach ($menu->categories as $category)
                                <span class="badge">{{ $category->nama_kategori }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning"> <i
                                class="bi bi-pencil-square"></i> </a>
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="no-menu">Tidak ada menu </p>
            @endforelse
        </div>
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content">
                    <!-- Previous Button -->
                    <li class="page-item {{ $menus->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $menus->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <!-- Page Numbers -->
                    @foreach ($menus->getUrlRange(1, $menus->lastPage()) as $page => $url)
                        <li class="page-item {{ $menus->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <!-- Next Button -->
                    <li class="page-item {{ $menus->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $menus->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Script untuk SweetAlert -->
    <script>
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah form submit otomatis
                const form = this.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Menu ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Melanjutkan pengiriman form
                    }
                });
            });
        });
    </script>

    <style>
        .pagination {
            justify-content: center;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            border: 1px solid #ddd;
            color: #495057;
            border-radius: 5px;
        }

        .pagination .page-link:hover {
            background-color: #389ee2;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #386ee2;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
        }
    </style>

@endsection
