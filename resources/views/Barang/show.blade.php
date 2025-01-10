@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('barang.index') }}" class="btn btn-primary mb-3">
        <i class="fa fa-angle-left"></i> Balik
    </a>
    <h3>Details Barang</h3>
    @if(session('success-stok'))
        <div class="alert alert-success">
            <p>Tambah Stok Berhasil!</p>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            <p>Tambah Data Berhasil!</p>
        </div>
    @endif
    @if(session('remove'))
        <div class="alert alert-danger">
            <p>Hapus Data Berhasil!</p>
        </div>
    @endif

    <table class="table table-striped">
        <tr>
            <td>ID Barang</td>
            <td>{{ $barang->id }}</td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>{{ $barang->kategori->nama_kategori }}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td>Merk Barang</td>
            <td>{{ $barang->merk }}</td>
        </tr>
        <tr>
            <td>Harga Beli</td>
            <td>{{ $barang->harga_beli }}</td>
        </tr>
        <tr>
            <td>Harga Jual</td>
            <td>{{ $barang->harga_jual }}</td>
        </tr>
        <tr>
            <td>Satuan Barang</td>
            <td>{{ $barang->satuan_barang }}</td>
        </tr>
        <tr>
            <td>Stok</td>
            <td>{{ $barang->stok }}</td>
        </tr>
        <tr>
            <td>Tanggal Input</td>
            <td>{{ $barang->tgl_input }}</td>
        </tr>
        <tr>
            <td>Tanggal Update</td>
            <td>{{ $barang->tgl_update }}</td>
        </tr>
        <tr>
            <td>Admin/User</td>
            <td>{{ $barang->user->name }}</td>
        </tr>
    </table>
</div>
@endsection