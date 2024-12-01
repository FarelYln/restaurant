@extends('layouts.admin_landing.app')

@section('content')
<div class="container">
    <h1>Daftar Meja</h1>
    <a href="{{ route('admin.meja.create') }}" class="btn btn-primary mb-3">Tambah Meja</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nomor Meja</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meja as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nomor_meja }}</td>
                    <td>{{ $item->kapasitas }}</td>
                    <td>
                        <a href="{{ route('admin.meja.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
