@extends('layouts.landing_page.app')
@section('content')
    <style>
        .card-img-container {
            height: 200px;
            /* Sesuaikan tinggi gambar sesuai keinginan */
            overflow: hidden;
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
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
                    <a href="/reservasi/create" class="btn py-sm-3 px-sm-5 me-3 animated slideInLeft"
                        style="background-color: orange; color: white; border: none; text-decoration: none;">Reservasi
                        Sekarang</a>
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
        <!-- Floor and Room Layout Start -->
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">Temukan Suasana Istimewa di Restoran Kami</h2>
                <div class="row g-4">
                    <!-- Lantai 1 -->
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card border-0 shadow h-100">
                            <div class="card-img-container">
                                <img class="card-img-top img-fluid rounded-top object-fit-cover"
                                    src="{{ asset('asset_landing/img/floor 3.jpeg') }}" alt="Lantai 1">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Lantai 1</h5>
                                <p class="card-text text-muted">Lantai utama dengan meja untuk keluarga besar dan area
                                    bersantap bersama.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Lantai 2 -->
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card border-0 shadow h-100">
                            <div class="card-img-container">
                                <img class="card-img-top img-fluid rounded-top object-fit-cover"
                                    src="{{ asset('asset_landing/img/floor 4.jpeg') }}" alt="Lantai 2">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Lantai 2</h5>
                                <p class="card-text text-muted">Ruang bersantap pribadi dengan suasana tenang, ideal untuk
                                    acara khusus atau pertemuan kecil.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Area Luar -->
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="card border-0 shadow h-100">
                            <img class="card-img-top img-fluid rounded-top object-fit-cover"
                            src="{{ asset('asset_landing/img/floor2.jpg') }}"
                                alt="Area Luar">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Area Luar</h5>
                                <p class="card-text text-muted">Area terbuka dengan pemandangan taman, cocok untuk
                                    menikmati udara segar dan suasana santai.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Ruangan Dalam -->
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card border-0 shadow h-100">
                            <img class="card-img-top img-fluid rounded-top object-fit-cover"
                            src="{{ asset('asset_landing/img/floor1.jpg') }}"
                                alt="Ruangan Dalam">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Area Dalam</h5>
                                <p class="card-text text-muted">Ruang indoor dengan dekorasi modern, dilengkapi dengan meja
                                    kecil untuk pasangan atau keluarga kecil.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floor and Room Layout End -->

        <!-- Gallery Start -->
<div class="container-xxl py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Galeri Meja Kami</h2>
        <div class="row g-4">
            <!-- Meja untuk 1 Orang -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-0 shadow h-100">
                    <img class="card-img-top rounded-top object-fit-cover"
                        src="{{ asset('asset_landing/img/meja01.jpeg') }}" alt="Meja untuk 1 Orang">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Meja untuk 2 Orang</h5>
                        <p class="card-text text-muted">Cocok untuk bersantap bersama pasangan anda.</p>
                    </div>
                </div>
            </div>
            <!-- Meja untuk 2 Orang -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="card border-0 shadow h-100">
                    <img class="card-img-top img-fluid rounded-top object-fit-cover"
                        src="{{ asset('asset_landing/img/meja3.jpg') }}" alt="Meja untuk 4 Orang">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Meja untuk 4 Orang</h5>
                        <p class="card-text text-muted">Pas untuk makan bersama dengan keluarga kecil.</p>
                    </div>
                </div>
            </div>
            <!-- Meja untuk 3 Orang -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-0 shadow h-100">
                    <img class="card-img-top img-fluid rounded-top object-fit-cover"
                        src="{{ asset('asset_landing/img/meja4.jpg') }}" alt="Meja untuk 8 Orang">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Meja untuk 8 Orang</h5>
                        <p class="card-text text-muted">Ideal untuk keluarga dan teman teman anda.</p>
                    </div>
                </div>
            </div>
            <!-- Meja untuk 4 Orang -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="card border-0 shadow h-100">
                    <img class="card-img-top img-fluid rounded-top object-fit-cover"
                        src="{{ asset('asset_landing/img/meja04.jpeg') }}" alt="Meja untuk 4 Orang">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Meja untuk 10 Orang</h5>
                        <p class="card-text text-muted">Meja dengan kursi banyak dan nyaman untuk keluarga.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gallery End -->

<style>
.card {
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    backface-visibility: hidden;
}

.card:hover {
    transform: scale(1.02) translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}
</style>

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
                                        <div class="d-flex align-items-center border rounded p-3 shadow-sm"
                                            style="font-size: 0.9rem;">
                                            <!-- Gambar Menu -->
                                            <a href="{{ route('user.menu.show', $menu->id) }}">
                                                <img class="img-fluid rounded-3"
                                                    src="{{ asset('storage/' . $menu->image) }}"
                                                    alt="{{ $menu->nama_menu }}" style="max-width: 80px; height: auto;">
                                            </a>
                                            <!-- Informasi Menu -->
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>{{ $menu->nama_menu }}</span>
                                                    <span class="text-primary">Rp
                                                        {{ number_format($menu->harga, 2, ',', '.') }}</span>
                                                </h5>
                                                <small class=" text-muted">{{ $menu->description }}</small>
                                                <div class="mt-2">
                                                    <!-- Kategori -->
                                                    <small class="">Kategori:
                                                        <div class="d-flex flex-wrap mt-1">
                                                            @foreach ($menu->categories as $category)
                                                                <span class="badge me-1 mb-1"
                                                                    style="background-color: {{ $category->color ?? '#ffa500' }};">
                                                                    {{ $category->nama_kategori }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <!-- Rating -->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->



        <!-- Team Start -->
        <div class="container-xxl pt-5 pb-3">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Anggota Tim</h5>
                    <h1 class="mb-5">Koki Utama Kami</h1>
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
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""
                                    style="background-color: orange; color: white;"><i class="fab fa-instagram"></i></a>
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
                        <p>Pengalaman yang luar biasa, sangat profesional dan melayani dengan sangat baik.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('asset_landing/img/2.jpg') }}" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Polo</h5>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>Pengalaman yang luar biasa! Mereka sangat profesional dan melayani dengan sangat baik.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('asset_landing/img/3.jpg') }}" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Maldini</h5>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>Pelayanan yang sangat memuaskan! Kami akan kembali lagi untuk menggunakan layanan mereka.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('asset_landing/img/3.jpg') }}" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Fernando Torres</h5>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>Suasana yang sangat menyenangkan, sangat cocok untuk acara keluarga atau bisnis!</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="{{ asset('asset_landing/img/2.jpg') }}" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Agus</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top" style="background-color: orange; color: white;"><i
                class="bi bi-arrow-up"></i></a>
    </div>
@endsection
