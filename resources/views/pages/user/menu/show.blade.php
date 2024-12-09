@extends('layouts.landing_page.app')

@section('content')
<style>
    /* Scroll untuk daftar ulasan */
    .review-list {
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .star-rating {
        display: inline-flex;
        direction: rtl;
        font-size: 1.5rem;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: lightgray;
        cursor: pointer;
    }

    .star-rating input:checked~label {
        color: gold;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: gold;
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

    .btn-primary {
        font-weight: bold;
    }

    .card-review {
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f8f9fa;
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
    <!-- Detail Menu -->
    <div class="card shadow border-0 mb-5">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}"
                     class="img-fluid rounded-start w-60 object-fit-cover mx-auto d-block mt-3">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title mb-3"><strong>Nama Menu:</strong> {{ $menu->nama_menu }}</h5>
                    <p class="card-price mb-3"><strong>Harga:</strong> Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
                    <p class="card-description mb-3"><strong>Deskripsi:</strong> {{ $menu->description }}</p>
                    <div class="card-categories mb-4">
                        <strong>Kategori:</strong>
                        @foreach ($menu->categories as $category)
                            <span class="badge bg-primary">{{ $category->nama_kategori }}</span>
                        @endforeach
                    </div>
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

    <!-- Form Ulasan -->
    <div class="card shadow border-0 mb-5">
        <div class="card-body">
            <h5 class="mb-4"><strong>Berikan Ulasan</strong></h5>
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

    <!-- Ulasan -->
    <div class="card shadow border-0">
        <div class="card-body">
            <h5 class="mb-4"><strong>Ulasan</strong></h5>
            @if ($menu->ulasans->isEmpty())
                <p class="text-center">Tidak ada ulasan untuk menu ini.</p>
            @else
                <div class="review-list">
                    @foreach ($menu->ulasans as $ulasan)
                        <div class="card card-review">
                            <h6><strong>{{ $ulasan->user->name }}</strong></h6>
                            <div class="star-ratting mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $ulasan->rating ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                            <p>{{ $ulasan->description }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
