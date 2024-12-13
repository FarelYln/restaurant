@extends('layouts.landing_page.app')
@section('content')
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Profil</h1>
            <p class="text-white-50 mb-4">
            Profil restoran kami 
            </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Profil</li>
                </ol>
            </nav>
        </div>
    </div>
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
                    <h1 class="mb-4">Selamat Datang di <i class="fa fa-utensils text-primary me-2"></i>Restoran Kami</h1>
                    <p class="mb-4">Kami mengutamakan pengalaman kuliner yang tak terlupakan dengan cita rasa yang
                        menggugah selera. Di restoran kami, setiap hidangan disiapkan dengan bahan-bahan berkualitas terbaik
                        dan resep yang penuh perhatian.</p>
                    <p class="mb-4">Dengan layanan yang ramah dan suasana yang nyaman, kami berkomitmen untuk memberikan
                        pelayanan terbaik kepada setiap tamu. Nikmati perjalanan rasa yang unik dan penuh kenangan bersama
                        kami.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15</h1>
                                <div class="ps-4">
                                    <p class="mb-0">Tahun</p>
                                    <h6 class="text-uppercase mb-0">Pengalaman Kuliner</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50</h1>
                                <div class="ps-4">
                                    <p class="mb-0">Koki</p>
                                    <h6 class="text-uppercase mb-0">Terdepan & Terkenal</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bagian Sejarah Restoran -->
            <div class="row g-5 align-items-center mt-5">
                <div class="col-lg-6">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Sejarah Kami</h5>
                    <h1 class="mb-4">Bagaimana Semua Dimulai</h1>
                    <p class="mb-4">
                        Restoran kami didirikan pada tahun 2008 oleh seorang chef berbakat dengan mimpi besar untuk membawa
                        pengalaman kuliner terbaik ke kota ini. Dimulai dengan restoran kecil, kami telah berkembang
                        menjadi salah satu destinasi kuliner paling populer di kota, berkat dedikasi kami terhadap kualitas
                        dan layanan.
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <img class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;"
                        src="{{ asset('asset_landing/img/alok.jpg') }}" alt="Foto Pemilik Restoran">
                    <h5 class="mt-3">John Doe</h5>
                    <p class="text-muted">Pendiri dan Pemilik</p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
@endsection
