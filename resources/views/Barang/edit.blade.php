@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Barang</h3>
    <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="{{ $barang->nama_barang }}" required>
        </div>
        <div class="form-group">
            <label for="merk">Merk</label>
            <input type="text" name="merk" class="form-control" id="merk" value="{{ $barang->merk }}" required>
        </div>
        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" id="harga_beli" value="{{ $barang->harga_beli }}" required>
        </div>
        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" id="harga_jual" value="{{ $barang->harga_jual }}" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" name="stok" class="form-control" id="stok" value="{{ $barang->stok }}" required>
        </div>
        <div class="mb-3">
            <label for="satuan_barang" class="form-label">Satuan Barang</label>
            <select class="form-control" id="satuan_barang" name="satuan_barang" required>
                <option value="">-- Pilih Satuan --</option>
                <option value="">-- Pilih Satuan --</option>
                <option value="PCS">PCS</option>
                <option value="BOX">BOX</option>
                <option value="PACK">PACK</option>
                <option value="Kilogram">Kilogram</option>
                <option value="Meter">Meter</option>
                <option value="Milimeter">Milimeter</option>
                <option value="Zak">Zak</option>
                <option value="Kaleng">Kaleng</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" class="form-control" required>
                @foreach($kategori as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ $barang->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Barang</button>
        <a href="{{ route('barang') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
