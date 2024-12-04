@extends('layouts.admin_landing.app')

@section('content')
<div class="container mt-5">
    <div class="card" 
    style="border-radius: 25px 25px 10px 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="container">
            <h1 class="mt-5">List Meja</h1>

            <!-- Tombol Tambah Meja -->
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-primary btn-md" onclick="location.href='{{ route('admin.meja.create') }}'" 
                        style="position: absolute; bottom: 10px; right: 10px;">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Menampilkan Pesan -->
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <!-- Tabel Daftar Meja -->
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded-3" style="max-width: 1100px; margin: 0 auto;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-5">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nomor Meja</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meja as $item)
                                <tr class="border-bottom">
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_meja }}</td>
                                    <td>{{ $item->kapasitas }}</td>
                                    <td>
                                        <span class="badge {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.meja.edit', $item->id) }}" 
                                           class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada meja ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
