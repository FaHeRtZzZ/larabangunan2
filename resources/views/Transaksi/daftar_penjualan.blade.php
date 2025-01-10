@extends('layouts.app')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12 main-chart">
                <h3>Daftar Penjualan</h3>
                <br>
                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Tombol Kembali ke Halaman Penjualan --}}
                <div class="mb-3">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Halaman Penjualan
                    </a>
                </div>

                {{-- Panel Cari Penjualan --}}
                <div class="panel-body">
                    <form method="GET" action="{{ route('penjualan.daftar') }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Cari berdasarkan Nama Barang" value="{{ request('keyword') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </span>
                        </div>
                    </form>
                </div>
                <br>

                {{-- Tabel Penjualan --}}
                @if($penjualan->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang</th>
                                <th>Tanggal</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $index => $item)
                                <tr>
                                    <td>{{ $penjualan->firstItem() + $index }}</td> {{-- Nomor urut --}}
                                    <td>{{ $item->barang->nama_barang }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('penjualan.delete.penjualan', $item->id_penjualan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus? Ini akan menghapus laporan penjualan.')">Hapus</button>
                                        </form>                                        
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $penjualan->links() }}
                    </div>
                @else
                    <p>Data penjualan tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </section>
</section>
@endsection
