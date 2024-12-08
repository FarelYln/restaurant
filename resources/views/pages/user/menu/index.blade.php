@extends('layouts.landing_page.app')

@section('content')
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Daftar Menu</h1>
            <p class="text-white-50 mb-4">
                Hubungi kami untuk informasi lebih lanjut, saran, atau bantuan terkait layanan kami.
                Kami dengan senang hati akan membantu Anda.
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
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Makanan</h5>
                <h1 class="mb-5">Item Paling Populer</h1>
            </div>
            <div class="row">
                <!-- Sidebar untuk kategori -->
                <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control p-2" placeholder="Cari menu..."
                                aria-label="Search" style="border-radius: 4px 0 0 4px;">
                            <button class="btn btn-outline-primary" type="submit"
                                style="border-radius: 0 4px 4px 0; border: 1px solid #c5baa9; background-color: #ecd8c3; color: #be9662;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h4 class="mb-4">Category</h4>
                        <ul class="list-unstyled fruite-categorie">
                            <li>
                                <div class="d-flex justify-content-between fruite-name">
                                    <a href="#"><i class="fas fa-th-large me-2"></i>All Menu</a>
                                    <span>({{ $menus->total() }})</span>
                                </div>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <div class="d-flex justify-content-between fruite-name">
                                        <a href="#"><i class="fas fa-utensils me-2"></i>
                                            {{ $category->nama_kategori }}</a>
                                        <span>({{ $category->menus->count() }})</span>
                                    </div>
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
                                <div class="d-flex align-items-start border rounded p-2 shadow-sm"
                                    style="font-size: 0.9rem;">
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
                                        <small class="fst-italic text-muted"
                                            style="font-size: 0.8rem;">{{ $menu->description }}</small>
                                        <div class="card-categories mt-2">
                                            @foreach ($menu->categories as $category)
                                                <span class="badge bg-secondary"
                                                    style="font-size: 0.75rem;">{{ $category->nama_kategori }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
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

    <style>
        .pagination {
            border-radius: 5px;
            background-color: #f9deb9;
            box-shadow: 0 2px 4px #ddd;
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
