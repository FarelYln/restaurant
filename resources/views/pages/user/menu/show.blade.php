@extends('layouts.landing_page.app')

@section('content')
    <style>
        .star-rating {
            display: inline-flex;
            direction: rtl;
            /* Bintang dari kiri ke kanan */
            font-size: 1.5rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: lightgray;
            /* Warna bintang default */
            cursor: pointer;
        }

        /* Atur bintang saat dipilih */
        .star-rating input:checked~label {
            color: gold;
            /* Warna kuning untuk bintang yang dipilih */
        }

        /* Atur bintang saat dihover */
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: gold;
            /* Warna kuning saat hover */
        }

        /* Atur bintang yang sudah dipilih dan saat dihover */
        .star-rating input:checked+label,
        .star-rating input:checked+label~label {
            color: gold;
            /* Warna kuning untuk bintang yang dipilih */
        }

        /* Gradasi untuk kartu ulasan */
        .card-review:nth-child(1) {
            background: linear-gradient(to right, #ffffff, #fff9cf);
            color: #333;
        }

        .card-review:nth-child(2) {
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            color: #333;
        }

        .card-review:nth-child(3) {
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            color: #333;
        }

        .card-review:nth-child(4) {
            background: linear-gradient(to right, #84fab0, #8fd3f4);
            color: #333;
        }

        .card-review:nth-child(5) {
            background: linear-gradient(to right, #8fd3f4, #a1c4fd);
            color: #333;
        }

        /* Tambahan gaya untuk semua kartu ulasan */
        .card-review {
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .card-review:hover {
            transform: scale(1.05);
        }

        .star {
            font-size: 20px;
            color: lightgray;
        }

        .star.filled {
            color: gold;
        }

        .badge {
            margin-right: 5px;
        }

        .form-select,
        .form-control {
            border-radius: 5px;
        }

        .btn-success {
            font-weight: bold;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .container-xxl {
            background-color: #000;
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        .container {
            padding: 3rem;
        }
    </style>

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5 text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Detail Menu</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Detail Menu</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">

        <!-- Detail Menu dan Gambar -->
        <div class="card shadow border-0 mb-5">
            <div class="row g-0">
                <!-- Gambar Menu -->
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}"
                        class="img-fluid rounded-start w-60 object-fit-cover mx-auto d-block mt-3">
                </div>

                <!-- Detail Menu -->
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><strong>Nama Menu:</strong> {{ $menu->nama_menu }}</h5>
                        <p class="card-price mb-3"><strong>Harga:</strong> Rp {{ number_format($menu->harga, 2, ',', '.') }}
                        </p>
                        <p class="card-description mb-3"><strong>Deskripsi:</strong> {{ $menu->description }}</p>
                        <div class="card-categories mb-4">
                            <strong>Kategori:</strong>
                            @foreach ($menu->categories as $category)
                                <span class="badge bg-primary">{{ $category->nama_kategori }}</span>
                            @endforeach
                        </div>

                        <!-- Rata-rata Rating -->
                        <h5 class="mb-3"><strong>Rata-rata Rating:</strong></h5>
                        <div class="star-ratting mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                            @endfor
                            <span> ({{ number_format($averageRating, 1) }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!-- Ulasan -->
<div class="card shadow border-0">
    <div class="card-body">
        <h3 class="mb-4">Ulasan</h3>
        @if ($menu->ulasans->isEmpty())
            <p class="text-center">Tidak ada ulasan untuk menu ini.</p>
        @else
            <div class="row">
                @foreach ($menu->ulasans as $ulasan)
                    <div class="col-md-6">
                        <div class="card card-review shadow border-0">
                            <div class="card-body">
                                <h6>
                                    <strong>{{ $ulasan->user->name }}</strong>
                                </h6>
                                <!-- Rating di bawah nama pengguna -->
                                <div class="star-ratting mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $ulasan->rating ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <p>{{ $ulasan->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Form Ulasan -->
        <h5 class="mb-3 mt-5"><strong>Berikan Ulasan</strong></h5>
        <form action="{{ route('ulasans.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_menu" value="{{ $menu->id }}">

            <div class="mb-3">
                <label for="rating" class="form-label">Rating:</label>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" id="star{{ $i }}" name="rating"
                               value="{{ $i }}" required>
                        <label for="star{{ $i }}" title="{{ $i }} Bintang">&#9733;</label>
                    @endfor
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi:</label>
                <textarea name="description" id="description" class="form-control" rows="4"
                          placeholder="Tulis ulasan Anda di sini..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
    </div>
</div>

    @endsection
