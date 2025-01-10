@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Data Kategori</h3>

    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('remove'))
        <div class="alert alert-danger">
            <p>{{ session('remove') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('kategori.store') }}" class="mb-4">
        @csrf
        <div class="input-group">
            <input 
                type="text" 
                name="kategori" 
                class="form-control @error('kategori') is-invalid @enderror" 
                placeholder="Masukkan Kategori Barang Baru" 
                value="{{ old('kategori') }}" 
                required>
            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Insert Data</button>
        </div>
        @error('kategori')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </form>

    <table class="table table-bordered text-center">
        <thead class="table-primary">
            <tr>
                <th>No.</th>
                <th>Kategori</th>
                <th>Tanggal Input</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->tgl_input }}</td>
                    <td>
                        <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $kategori->links() }}
    </div>    
</div>
@endsection
