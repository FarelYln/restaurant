@extends('layouts.admin_landing.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Lokasi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.location.update', $location) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Lokasi</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $location->name) }}"
                           placeholder="Masukkan nama lokasi">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="floor">Lantai</label>
                    <input type="number" 
                           class="form-control @error('floor') is-invalid @enderror" 
                           id="floor" 
                           name="floor" 
                           value="{{ old('floor', $location->floor) }}"
                           placeholder="Masukkan nomor lantai">
                    @error('floor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <a href="{{ route('admin.location.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection