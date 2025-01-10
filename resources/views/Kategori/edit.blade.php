@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kategori</h3>
    <br/>

    <form method="POST" action="{{ route('kategori.update', $kategori->id_kategori) }}">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="kategori" value="{{ $kategori->nama_kategori }}" class="form-control" required>
            <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i> Ubah Data</button>
        </div>
    </form>
</div>
@endsection
