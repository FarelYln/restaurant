@extends('layouts.landing_page.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Makanan</h5>
            <h1 class="mb-5">Item Paling Populer</h1>
        </div>
        <div class="row">
            <!-- Sidebar untuk kategori -->
            <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                <!-- Search bar -->
                <div class="mb-4">
                    <div class="input-group">
                        <form method="GET" action="{{ route('menus.index') }}">
                            <input type="search" name="search" class="form-control p-2" placeholder="Cari menu..." aria-label="Search" style="border-right: none; border-radius: 4px 0 0 4px;">
                            <button class="btn btn-outline-primary" type="submit" style="border-radius: 0 4px 4px 0; border: 1px solid #c5baa9; background-color: #ecd8c3; color: #be9662;">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
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
                        @foreach($categories as $category)
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="#">{{ $category->nama_kategori }}</a>
                                <span>({{ $category->menus->count() }})</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Menu items -->
            <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                <div class="row g-4">
                    @foreach($menus as $menu)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.menu.show', $menu->id) }}">
                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" style="width: 80px;">
                            </a>
                            <div class="w-100 d-flex flex-column text-start ps-4">
                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                    <span>{{ $menu->nama_menu }}</span>
                                    <span class="text-primary">Rp {{ number_format($menu->harga, 2, ',', '.') }}</span>
                                </h5>
                                <small class="fst-italic">{{ $menu->description }}</small>
                                <div class="card-categories mt-2">
                                    @foreach($menu->categories as $category)
                                        <span class="badge">{{ $category->nama_kategori }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{ $menus->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection