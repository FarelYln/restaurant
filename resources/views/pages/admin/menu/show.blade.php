@extends('layouts.admin_landing.app')

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
            color: gold;
        }

        .star.filled {
            color: lightgray;
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
                        <p class="card-price mb-3"><strong>Harga:</strong> Rp {{ number_format($menu->harga, 2, ',', '.') }}
                        </p>
                        <p class="card-description mb-3"><strong>Deskripsi:</strong> {{ $menu->description }}</p>
                        <div class="card-categories mb-4">
                            <strong>Kategori:</strong>
                            @foreach ($menu->categories as $category)
                                <span class="badge bg-primary">{{ $category->nama_kategori }}</span>
                            @endforeach
                        </div>
                        <h5 class="mb-3"><strong>Rata-rata Rating:</strong></h5>
                        <div class="star-rating mb-3" style="direction: rtl; text-align: left;">
                            @for ($i = 5; $i >= 1; $i--)
                                <span class="star"
                                    style="color: {{ $i <= $averageRating ? 'gold' : 'lightgray' }}; display: inline-block;">
                                    ★
                                </span>
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
                        <!-- Form Ulasan -->
                        <div class="star-rating" style="direction: rtl; display: block; text-align: left;">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating"
                                    value="{{ $i }}" required>
                                <label for="star{{ $i }}" title="{{ $i }} Bintang"
                                    style="font-size: 1.5rem; cursor: pointer;">
                                    &#9733;
                                </label>
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
                                <div class="star-rating mb-2" style="direction: rtl; display: block; text-align: left;">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <span class="star"
                                            style="color: {{ $i <= $ulasan->rating ? 'gold' : 'lightgray' }}; font-size: 1.5rem;">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                                <p>{{ $ulasan->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    @endsection
