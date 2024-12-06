@extends('layouts.landing_page.app')
@section('content')
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Nikmati Hidangan<br>Lezat Bersama Kami</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">
                        Selamat datang di restoran kami, tempat di mana cita rasa istimewa dan pengalaman bersantap yang
                        nyaman bersatu.
                        Pesan meja Anda sekarang dan nikmati momen yang tak terlupakan bersama orang-orang terkasih.
                    </p>
                    <a href="#reservasi-form" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Reservasi
                        Sekarang</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="{{ asset('asset_landing/img/hero.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Menu Start -->
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
                            <input type="search" class="form-control p-2" placeholder="Cari menu..." aria-label="Search"
                                style="border-right: none; border-radius: 4px 0 0 4px;">
                            <button class="btn btn-outline-primary" type="button"
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
                                    <span>(12)</span>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex justify-content-between fruite-name">
                                    <a href="#"><i class="fas fa-bread-slice me-2"></i>Makanan</a>
                                    <span>(8)</span>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex justify-content-between fruite-name">
                                    <a href="#"><i class="fas fa-glass-martini me-2"></i>Minuman</a>
                                    <span>(6)</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Price filter -->
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <h4 class="mb-2">Price</h4>
                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0"
                                max="500" value="0" oninput="amount.value=rangeInput.value">
                            <output id="amount" name="amount" min-value="0" max-value="500" for="rangeInput">0</output>
                        </div>
                    </div>
                </div>
                <!-- Menu items -->
                <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="tab-class text-center">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade show active p-0">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-1.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-2.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-8.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-1.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-7.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-8.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-1.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-5.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-6.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-7.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded"
                                                src="{{ asset('asset_landing/img/menu-8.jpg') }}" alt=""
                                                style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo
                                                    diam</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Bagian pagination statis -->
                        <div class="mt-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#" tabindex="-1">1</a>
                                    </li>
                                    <li class="page-item" aria-current="page">
                                        <span class="page-link">2</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Menu End -->
        @endsection
