@extends('layouts.admin_landing.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Lokasi Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.location.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lokasi</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
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
                           value="{{ old('floor') }}"
                           placeholder="Masukkan nomor lantai">
                    @error('floor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <a href="{{ route('admin.location.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection