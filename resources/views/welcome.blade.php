@extends('layouts.landing_page.app')
@section('content')
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Selamat Datang di Restoran Kami</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">
                        Kami dengan senang hati menyambut Anda di tempat di mana rasa, kualitas, dan kenyamanan bertemu.
                        Jadikan setiap momen bersantap Anda lebih istimewa bersama kami.
                        Jelajahi menu terbaik kami dan nikmati pengalaman kuliner yang tak terlupakan.
                    </p>
                    <a href="/reservasi/create" class="btn py-sm-3 px-sm-5 me-3 animated slideInLeft" style="background-color: orange; color: white; border: none; text-decoration: none;">Reservasi Sekarang</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="{{ asset('asset_landing/img/hero.png') }}" alt="Restoran Kami">
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                                <h5>Koki Profesional</h5>
                                <p>Para koki kami memiliki keahlian tinggi dalam menciptakan hidangan yang menggugah selera.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                                <h5>Makanan Berkualitas</h5>
                                <p>Kami hanya menggunakan bahan terbaik untuk menyajikan hidangan yang lezat dan memuaskan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                                <h5>Reservasi Secara Online</h5>
                                <p>Mulai reservasi secara online melalui website ini dan rasakan pengalamannya.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                                <h5>Layanan 24/7</h5>
                                <p>Reservasi kapan saja dan dimana saja melalui website reservasi kami.
                                    <br>
                                    <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s"
                                    src="{{ asset('asset_landing/img/about-1.jpg') }}">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s"
                                    src="{{ asset('asset_landing/img/about-2.jpg') }}" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s"
                                    src="{{ asset('asset_landing/img/about-3.jpg') }}">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s"
                                    src="{{ asset('asset_landing/img/about-4.jpg') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Tentang Kami</h5>
                        <h1 class="mb-4">Selamat Datang di <i class="fa fa-utensils text-primary me-2"></i>Restoran</h1>
                        <p class="mb-4">Selamat datang di restoran kami, tempat di mana cita rasa istimewa dan pengalaman
                            bersantap yang nyaman bersatu. Kami berkomitmen untuk menyajikan hidangan yang memuaskan dengan
                            kualitas terbaik.</p>
                        <p class="mb-4">Dengan pelayanan yang ramah dan suasana yang menyenangkan, kami ingin setiap tamu
                            merasakan momen istimewa bersama kami. Nikmati hidangan lezat dan pengalaman bersantap yang tak
                            terlupakan di restoran kami.</p>
                            <div class="row g-4 mb-4">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                        <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15</h1>
                                        <div class="ps-4">
                                            <p class="mb-0">Tahun Pengalaman</p>
                                            <h6 class="text-uppercase mb-0">Pengalaman</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                        <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50</h1>
                                        <div class="ps-4">
                                            <p class="mb-0">Koki Terkenal</p>
                                            <h6 class="text-uppercase mb-0">Master Chef</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

<!-- Menu Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Makanan</h5>
            <h1 class="mb-5">Item Paling Populer</h1>
        </div>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach ($menus as $menu)
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <!-- Pastikan gambar diakses dengan benar -->
                                <a href="{{ route('user.menu.show', $menu->id) }}">
                                    <img class="img-fluid rounded-3" src="{{ asset('storage/' . $menu->image) }}"
                                        alt="{{ $menu->nama_menu }}" style="max-width: 80px; height: auto;">
                                </a>
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{ $menu->nama_menu }}</span>
                                        <span class="text-primary">${{ $menu->harga }}</span>
                                    </h5>
                                    <small class="fst-italic">Kategori: 
                                        @foreach ($menu->categories as $category)
                                            {{ $category->nama_kategori }}@if (!$loop->last), @endif
                                        @endforeach
                                    </small>
                                    <small class="fst-italic d-block mt-2">Rating Rata-rata: {{ $menu->averageRating ?? 'Belum ada rating' }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

       


      <!-- Team Start -->
<div class="container-xxl pt-5 pb-3">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Team Members</h5>
            <h1 class="mb-5">Our Master Chefs</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('asset_landing/img/team-1.jpg') }}" alt="">
                    </div>
                    <h5 class="mb-0">Chef Asep</h5>
                    <small>Executive Chef</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('asset_landing/img/team-2.jpg') }}" alt="">
                    </div>
                    <h5 class="mb-0">Chef Budi</h5>
                    <small>Chef de Partie</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('asset_landing/img/team-3.jpg') }}" alt="">
                    </div>
                    <h5 class="mb-0">Chef Agus</h5>
                    <small>Sous Chef</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('asset_landing/img/team-4.jpg') }}" alt="">
                    </div>
                    <h5 class="mb-0">Chef Juna</h5>
                    <small>Chef de Partie</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square mx-1" href="" style="background-color: orange; color: white;"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->


<!-- Testimonial Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Testimonial</h5>
            <h1 class="mb-5">Apa Kata Klien Kami!!!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore diam</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle"
                         src="{{ asset('asset_landing/img/testimonial-1.jpg') }}"
                         style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Marco Van Basten</h5>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore diam</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle"
                         src="{{ asset('asset_landing/img/testimonial-2.jpg') }}"
                         style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Paolo Maldini</h5>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore diam</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle"
                         src="{{ asset('asset_landing/img/testimonial-3.jpg') }}"
                         style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Fernando Torres</h5>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore diam</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle"
                         src="{{ asset('asset_landing/img/testimonial-4.jpg') }}"
                         style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Cold Palmer</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top" style="background-color: orange; color: white;"><i class="bi bi-arrow-up"></i></a>
    </div>
@endsection
