@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center">Data Barang</h3>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Form Pencarian -->
    <form action="{{ route('barang') }}" method="GET" class="form-inline mb-3">
        <div class="form-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari Barang" value="{{ request('keyword') }}">
        </div>
        <button type="submit" class="btn btn-primary ml-2">Cari</button>
        <a href="{{ route('barang') }}" class="btn btn-secondary ml-2">Reset</a>
        <a href="{{ route('barang.download') }}" class="btn btn-success ml-2">Unduh Data Barang</a>
    </form>

    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <table class="table table-bordered text-center">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>   
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barang as $b)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->merk }}</td>
                <td>{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                <td>{{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ $b->satuan_barang }}</td>
                <td>{{ $b->kategori->nama_kategori }}</td>
                <td>
                    <a href="{{ route('barang.edit', $b->id_barang) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('barang.destroy', $b->id_barang) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Barang tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Tambahkan Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $barang->links() }}
    </div>
</div>
@endsection
