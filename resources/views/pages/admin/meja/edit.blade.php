@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1>Edit Meja</h1>
    <form action="{{ route('admin.meja.update', $meja->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nomor_meja" class="form-label">Nomor Meja</label>
            <input type="number" class="form-control @error('nomor_meja') is-invalid @enderror" id="nomor_meja" name="nomor_meja" value="{{ old('nomor_meja', $meja->nomor_meja) }}">
            @error('nomor_meja')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $meja->kapasitas) }}">
            @error('kapasitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
