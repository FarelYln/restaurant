@extends('layouts.admin_landing.app')

@section('content')
<div class="container mt-5">
    <div class="card" 
         style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="text-center mb-4">Edit Lokasi</h2>
            <form action="{{ route('admin.location.update', $location) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Input Nama Lokasi -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lokasi</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $location->name) }}"
                           placeholder="Masukkan nama lokasi">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Lantai -->
                <div class="mb-3">
                    <label for="floor" class="form-label">Lantai</label>
                    <input type="number" 
                           class="form-control @error('floor') is-invalid @enderror" 
                           id="floor" 
                           name="floor" 
                           value="{{ old('floor', $location->floor) }}"
                           placeholder="Masukkan nomor lantai">
                    @error('floor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Update -->
                <div class="text-center mt-4">
                    <a href="{{ route('admin.location.index') }}" class="btn btn-secondary px-4 rounded-pill me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
