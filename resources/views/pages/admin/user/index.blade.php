@extends('layouts.admin_landing.app')

@section('content')
    <style>
        .card { border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border: none; }
        .card-header { background-color: #f8fafc; font-size: 1.25rem; font-weight: bold; padding: 15px; border-bottom: 1px solid #e2e8f0; }
        .card-body { padding: 20px; }
        .table th, .table td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
        .table th { font-weight: bold; }
        .table tbody tr:last-child td { border-bottom: none; }
        .pagination { justify-content: center; margin-top: 20px; }
    </style>

    <div class="container mt-5">
        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('account.index') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari Pengguna:</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" class="form-control" placeholder="Masukkan nama atau email...">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Urutkan:</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="created_at" {{ $sort == 'created_at' ? 'selected' : '' }}>Akun Terbaru</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header text-center">
                Daftar Semua Akun
            </div>
            <div class="card-body">
                @if ($users->isEmpty())
                    <div class="alert alert-warning text-center">
                        Tidak ada akun yang ditemukan.
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Navigasi Pagination -->
                    <div class="pagination-wrapper">
                        {{ $users->appends(['search' => $search, 'sort' => $sort])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
