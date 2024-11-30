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
    <div class="container-xxl py-5">
        <div class="container">
            <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservasi</h5>
            <h1 class="mb-4">Daftar Reservasi</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Reservasi</th>
                            <th>Jam</th>
                            <th>Jumlah Orang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>2024-12-01</td>
                            <td>19:00</td>
                            <td>4</td>
                            <td>
                                <span class="badge bg-warning">Pending</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>2024-12-02</td>
                            <td>20:00</td>
                            <td>2</td>
                            <td>
                                <span class="badge bg-success">Confirmed</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-4">
                <a href="#" class="btn btn-primary py-3 px-5">Tambah Reservasi</a>
            </div>
        </div>
    </div>
@endsection
