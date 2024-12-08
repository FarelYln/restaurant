@extends('layouts.landing_page.app')

@section('content')
    <div class="container">
        <div class="header-card">
            <h1 class="title">{{ $menu->nama_menu }}</h1>
        </div>
        <div class="card">
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="card-img"
                style="width: 100%; height: auto;">
            <div class="card-body">
                <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                <p class="card-price">Rp {{ number_format($menu->harga, 2, ',', '.') }}</p>
                <p class="card-description">{{ $menu->description }}</p>
                <div class="card-categories">
                    @foreach ($menu->categories as $category)
                        <span class="badge">{{ $category->nama_kategori }}</span>
                    @endforeach
                </div>

                <!-- Menampilkan Rata-rata Rating -->
                <h3>Rata-rata Rating:</h3>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                    @endfor
                    <span> ({{ number_format($averageRating, 1) }})</span>
                </div>

                <!-- Formulir Ulasan -->
                <h3>Berikan Ulasan:</h3>
                <form action="{{ route('ulasans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_menu" value="{{ $menu->id }}">

                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="">Pilih Rating</option>
                        <option value="1">1 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="5">5 Bintang</option>
                    </select>

                    <label for="description">Deskripsi:</label>
                    <textarea name="description" id="description" rows="4" placeholder="Tulis ulasan Anda di sini..."></textarea>

                    <button type="submit" class="btn btn-success">Kirim Ulasan</button>
                </form>

                <!-- Menampilkan Ulasan -->
                <h3>Ulasan:</h3>
                <div class="row">
                    <div class="col-md-8">
                        @if ($menu->ulasans->isEmpty())
                            <p>Tidak ada ulasan untuk menu ini.</p>
                        @else
                            <ul>
                                @foreach ($menu->ulasans as $ulasan)
                                    <li>
                                        <strong>{{ $ulasan->user->name }}</strong> - {{ $ulasan->rating }} Bintang
                                        <p>{{ $ulasan->description }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .star {
            font-size: 20 px;
            color: lightgray;
        }

        .star.filled {
            color: gold;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-8,
        .col-md-4 {
            padding: 15px;
        }
    </style>
@endsection
