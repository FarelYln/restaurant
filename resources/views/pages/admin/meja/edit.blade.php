@extends('layouts.admin_landing.app')

@section('content')
<div class="container mt-5">
    <div class="card" 
         style="border-radius: 10px 10px 10px 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="text-center mb-4">Edit Meja</h2>
            <form action="{{ route('admin.meja.update', $meja->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Nomor Meja -->
                <div class="mb-3">
                    <label for="nomor_meja" class="form-label">Nomor Meja</label>
                    <input type="number" 
                           class="form-control @error('nomor_meja') is-invalid @enderror" 
                           id="nomor_meja" 
                           name="nomor_meja" 
                           value="{{ old('nomor_meja', $meja->nomor_meja) }}" 
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
                           value="{{ old('kapasitas', $meja->kapasitas) }}" 
                           placeholder="Masukkan kapasitas">
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilihan Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Meja</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="tersedia" {{ old('status', $meja->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status', $meja->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dropdown Lokasi -->
                <div class="mb-3">
                    <label for="location_id" class="form-label">Lokasi</label>
                    <select id="location_id" name="location_id" class="form-select @error('location_id') is-invalid @enderror" onchange="updateFloor()">
                        <option value="">Pilih Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $meja->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }} | Lantai {{ $location->floor }}</option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Menampilkan Lantai -->
                <div class="mb-3" id="floor_display" style="display: none;">
                    <label class="form-label">Lantai</label>
                    <input type="text" class="form-control" id="floor" value="{{ old('floor', $meja->location->floor ?? '') }}" readonly>
                </div>

                <!-- Tombol Update -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk memperbarui tampilan lantai berdasarkan lokasi yang dipilih
    function updateFloor() {
        const locationSelect = document.getElementById('location_id');
        const floorInput = document.getElementById('floor const floorDisplay = document.getElementById('floor_display');
        const selectedLocation = locationSelect.options[locationSelect.selectedIndex];

        if (selectedLocation.value) {
            // Misalkan kita memiliki data lantai dalam atribut data
            floorInput.value = selectedLocation.getAttribute('data-floor') || '';
            floorDisplay.style.display = 'block';
        } else {
            floorInput.value = '';
            floorDisplay.style.display = 'none';
        }
    }
</script>
@endsection