@extends('layouts.admin_landing.app')

@section('content')
<!-- Hero Header -->
<header class="bg-info text-white text-center py-5">
    <br>
    <br>
    <div class="container">
        <h1 class="display-4 font-weight-bold text-white">{{ __('Pengaturan Profil') }}</h1>
        <p class="lead text-white">{{ __('Perbarui informasi profil dan kata sandi akun Anda.') }}</p>
    </div>
</header>


<br>
<br>
<br>
<div class="main-panel">
    <div class="container-fluid py-5">
        <div class="row">
            <!-- Profile Information Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-light rounded mb-4">
                    <div class="card-body">
                        <h2 class="h5 font-weight-bold text-dark">{{ __('Informasi Profil') }}</h2>
                        <p class="text-muted small">{{ __("Perbarui informasi profil dan alamat email akun Anda.") }}</p>
                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">{{ __('Nama') }}</label>
                                <input type="text" id="name" name="name" class="form-control w-100" 
                                       value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" class="form-control w-100" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('Simpan') }}</button>
                            @if (session('status') === 'profile-updated')
                            <p class="text-success small mt-2">{{ __('Tersimpan.') }}</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Password Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-light rounded mb-4">
                    <div class="card-body">
                        <h3 class="h5">{{ __('Perbarui Kata Sandi') }}</h3>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="current_password">{{ __('Kata Sandi Saat Ini') }}</label>
                                <input id="current_password" name="current_password" type="password" class="form-control">
                                @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">{{ __('Kata Sandi Baru') }}</label>
                                <input id="password" name="password" type="password" class="form-control">
                                @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">{{ __('Konfirmasi Kata Sandi') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                                @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('Simpan') }}</button>
                            @if (session('status') === 'password-updated')
                            <p class="text-success small mt-2">{{ __('Tersimpan.') }}</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="col-md-12">
                <div class="card shadow-sm border-light rounded mb-4">
                    <div class="card-body">
                        <h3 class="h5">{{ __('Hapus Akun') }}</h3>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <div class="form-group mb-3">
                                <label for="delete_password">{{ __('Kata Sandi') }}</label>
                                <input id="delete_password" name="password" type="password" class="form-control">
                                @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger w-100">{{ __('Hapus Akun') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
