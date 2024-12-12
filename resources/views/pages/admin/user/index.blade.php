@extends('layouts.admin_landing.app')

@section('content')
    <style>
        /* Gaya untuk kontainer tabel */
        .table-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Gaya untuk header tabel */
        .table-header {
            background-color: #4a5568;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Gaya untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead tr {
            background-color: #edf2f7;
        }

        th, td {
            padding: 12px;
            border: 1px solid #e2e8f0;
        }

        th {
            font-weight: 600;
            color: #4a5568;
        }

        td {
            color: #2d3748;
        }

        tbody tr:nth-child(odd) {
            background-color: #f7fafc;
        }

        tbody tr:nth-child(even) {
            background-color: #edf2f7;
        }
    </style>

    <div class="table-container">
        <div class="table-header">Data Pengguna</div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
