@extends('layouts.app') <!-- Sesuaikan dengan layout Anda -->

@section('content')
<div class="container">
    <h1>Tambah Barang</h1>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <!-- Anda bisa mengganti ini dengan data kategori dari database -->
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" class="form-control" id="merk" name="merk" required>
        </div>
        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
        </div>
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
        </div>
        <div class="mb-3">
            <label for="satuan_barang" class="form-label">Satuan Barang</label>
            <select class="form-control" id="satuan_barang" name="satuan_barang" required>
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
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection