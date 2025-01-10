@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Update Penjualan</h3>
        <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $penjualan->jumlah }}" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
