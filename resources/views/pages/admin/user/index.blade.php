@extends('layouts.admin_landing.app')

@section('content')
    <style>
        /* Gaya untuk card detail */
        .card {
            border-radius: 12px 12px 8px 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background-color: #f8fafc;
            font-size: 1.25rem;
            font-weight: bold;
            color: #2d3748;
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0;
        }

        .card-body {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 0 0 8px 8px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            font-weight: bold;
            color: #4a5568;
        }

        .table td {
            color: #2d3748;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>

    <div class="container mt-5"><!-- Dropdown untuk memilih akun -->
<!-- Dropdown untuk memilih akun -->
<form method="GET" action="{{ route('account.show') }}">
    <div class="row">
        <div class="col-md-6">
            <label for="type" class="form-label">Pilih Akun:</label>
            <select name="type" id="type" class="form-select mb-3" onchange="this.form.submit()">
                <option value="user" {{ request('type', $type) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('type', $type) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="sort" class="form-label">Urutkan Berdasarkan:</label>
            <select name="sort" id="sort" class="form-select mb-3" onchange="this.form.submit()">
                <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="created_at" {{ request('sort', 'name') == 'created_at' ? 'selected' : '' }}>Akun Terbaru</option>
            </select>
        </div>
    </div>
</form>



        <div class="card mt-3">
            <div class="card-header text-center">
                Detail Akun {{ ucfirst($type) }}
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th  style="text-align: center;">Nama</th>
                            <th  style="text-align: center;">Email</th>
                            <th  style="text-align: center;">Aksi</th>
                        </tr>
                        <tr>
                            <td  style="text-align: center;">{{ $user->name }}</td>
                            <td  style="text-align: center;">{{ $user->email }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
