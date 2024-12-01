@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1>Tambah Meja</h1>
    <form action="{{ route('admin.meja.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nomor_meja" class="form-label">Nomor Meja</label>
            <input type="number" class="form-control @error('nomor_meja') is-invalid @enderror" id="nomor_meja" name="nomor_meja" value="{{ old('nomor_meja') }}">
            @error('nomor_meja')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}">
            @error('kapasitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Menambahkan input status yang tersembunyi (hidden) -->
        <input type="hidden" name="status" value="tersedia">

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
