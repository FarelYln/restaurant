@extends('layouts.admin_landing.app')

@section('content')
<div class="container mt-5">
    <div class="card" 
         style="border-radius: 10px 10px 10px 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="text-center mb-4">Tambah Meja</h2>
            <form action="{{ route('admin.meja.store') }}" method="POST">
                @csrf
                <!-- Input Nomor Meja -->
                <div class="mb-3">
                    <label for="nomor_meja" class="form-label">Nomor Meja</label>
                    <input type="number" 
                           class="form-control @error('nomor_meja') is-invalid @enderror" 
                           id="nomor_meja" 
                           name="nomor_meja" 
                           value="{{ old('nomor_meja') }}" 
                           placeholder="Masukkan nomor meja">
                    @error('nomor_meja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Kapasitas -->
                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" 
                           class="form-control @error('kapasitas') is-invalid @enderror" 
                           id="kapasitas" 
                           name="kapasitas" 
                           value="{{ old('kapasitas') }}" 
                           placeholder="Masukkan kapasitas">
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dropdown Lokasi -->
                <div class="mb-3">
                    <label for="location_id" class="form-label">Lokasi</label>
                    <select id="location_id" name="location_id" class="form-select @error('location_id') is-invalid @enderror" onchange="updateFloor()">
                        <option value="">Pilih Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }} | Lantai {{ $location->floor }}</option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Menampilkan Lantai -->
                <div class="mb-3" id="floor_display" style="display: none;">
                    <label class="form-label">Lantai</label>
                    <input type="text" class="form-control" id="floor" readonly>
                </div>

                <!-- Input Status (Hidden) -->
                <input type="hidden" name="status" value="tersedia">

                <!-- Tombol Simpan -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFloor() {
        const locationSelect = document.getElementById('location_id');
        const floorInput = document.getElementById('floor_display');
        const floorField = document.getElementById('floor');

        const selectedLocationId = locationSelect.value;

        if (selectedLocationId) {
            // Mengambil data lokasi dari server (misalnya, menggunakan AJAX)
            fetch(`/locations/${selectedLocationId}`)
                .then(response => response.json())
                .then(data => {
                    floorField.value = data.floor; // Mengisi field lantai dengan data dari server
                    floorInput.style.display = 'block'; // Menampilkan field lantai
                });
        } else {
            floorInput.style.display = 'none'; // Menyembunyikan field lantai jika tidak ada lokasi yang dipilih
        }
    }
</script>
@endsection