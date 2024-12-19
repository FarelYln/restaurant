@extends('layouts.landing_page.app')

@section('content')
<style>
.menu-card{
    background-color: #ffffff;
}
</style>
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Daftar Menu</h1>
            <p class="text-white-50 mb-4">
                Berikut adalah menu menu yang ada di retoran kami.
            </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal mt-4">Menu Makanan</h5>
                <h1 class="mb-5">Semua Menu yang ada di restoran kami</h1>
            </div>
            <div class="row">
               <!-- Sidebar untuk kategori -->
<div class="col-lg-3 col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="0.1s">
    <!-- Search Form -->
    <div class="mb-4">
        <form method="GET" action="{{ route('user.menu.index') }}">
            <div class="input-group shadow-sm rounded">
                <input 
                    type="search" 
                    name="search" 
                    class="form-control p-2" 
                    placeholder="Cari menu..." 
                    aria-label="Search" 
                    value="{{ request('search') }}"
                    style="border-radius: 4px 0 0 4px;"
                >
                <button 
                    class="btn btn-primary" 
                    type="submit" 
                    style="border-radius: 0 4px 4px 0;">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Category List -->
    <div class="bg-white p-3 rounded shadow-sm">
        <h5 class="mb-3 fw-bold text-primary">Kategori Menu</h5>
        <ul class="list-unstyled mb-0">
            <li class="mb-2">
                <a href="{{ route('user.menu.index') }}" 
                   class="d-flex justify-content-between align-items-center text-decoration-none text-dark">
                    <span>
                        <i class="fas fa-th-large me-2 text-primary"></i> All Menu
                    </span>
                </a>
            </li>
            @foreach ($categories as $category)
                <li class="mb-2">
                    <a href="{{ route('user.menu.index', ['category' => $category->id]) }}" 
                       class="d-flex justify-content-between align-items-center text-decoration-none text-dark">
                        <span>
                            <i class="fas fa-utensils me-2 text-primary"></i> {{ $category->nama_kategori }}
                        </span>
                        <span class="badge bg-light text-dark">{{ $category->menus->count() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>


<!-- Menu items -->
<div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
    <div class="row g-3">
        @foreach ($menus as $menu)
            <div class="col-md-6 col-sm-12">
                <div class="menu-card d-flex align-items-start border rounded p-2 shadow-sm"
                    style="font-size: 0.9rem; transition: all 0.3s ease-in-out;">
                    <a href="{{ route('user.menu.show', $menu->id) }}">
                        <img class="img-fluid rounded-3" src="{{ asset('storage/' . $menu->image) }}"
                            alt="{{ $menu->nama_menu }}" style="max-width: 80px; height: auto;">
                    </a>
                    <div class="w-100 d-flex flex-column text-start ps-2">
                        <h5 class="d-flex justify-content-between border-bottom pb-1 mb-1">
                            <span class="fw-bold" style="font-size: 1rem;">{{ $menu->nama_menu }}</span>
                            <span class="text-primary" style="font-size: 0.9rem;">Rp
                                {{ number_format($menu->harga, 2, ',', '.') }}</span>
                        </h5>
                        <small class="text-muted" style="font-size: 0.8rem;">{{ $menu->description }}</small>
                        <div class="card-categories mt-2">
                            @foreach ($menu->categories as $category)
                                <span class="badge bg-primary"
                                    style="font-size: 0.75rem;">{{ $category->nama_kategori }}</span>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <!-- Rating Bintang -->
                            @if ($menu->averageRating)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $menu->averageRating)
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif ($i - $menu->averageRating < 1)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            @else
                                <small class="text-muted">Belum ada rating</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous Button -->
                <li class="page-item {{ $menus->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link"
                        href="{{ $menus->previousPageUrl() }}&search={{ request('search') }}&category={{ request('category') }}"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <!-- Page Numbers -->
                @foreach ($menus->getUrlRange(1, $menus->lastPage()) as $page => $url)
                    <li class="page-item {{ $menus->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $url }}&search={{ request('search') }}&category={{ request('category') }}">{{ $page }}</a>
                    </li>
                @endforeach
                <!-- Next Button -->
                <li class="page-item {{ $menus->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link"
                        href="{{ $menus->nextPageUrl() }}&search={{ request('search') }}&category={{ request('category') }}"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Custom CSS -->
<style>
    /* Hover effect for cards */
    .menu-card:hover {
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        transform: scale(1.02);
    }

    .menu-card {
        transition: all 0.3s ease-in-out;
    }
</style>

            </div>
        </div>
    </div>

    <style>
        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            border: 1px solid #ddd;
            color: #495057;
            border-radius: 5px;
        }

        .pagination .page-link:hover {
            background-color: #e28d38;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #e28d38;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
        }
    </style>
@endsection
