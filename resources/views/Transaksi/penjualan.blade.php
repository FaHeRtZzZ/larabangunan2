@extends('layouts.app')

@section('content')

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12 main-chart">
                <h3>Keranjang Penjualan</h3>
                <br>
                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('remove'))
                    <div class="alert alert-danger">
                        <p>{{ session('remove') }}</p>
                    </div>
                @endif

                {{-- Panel Cari Barang --}}
                <div class="row">
                    <div class="panel-body">
                        <form method="GET" action="{{ route('penjualan.index') }}">
                            <div class="input-group">
                                <input type="text" id="cari" class="form-control" name="keyword" placeholder="Masukan: Kode / Nama Barang" value="{{ old('keyword', $keyword ?? '') }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </span>
                            </div>
                        </form>                        
                    </div>
                </div>
                <div class="panel-body">
                    <a href="{{ route('penjualan.daftar') }}" class="btn btn-info">Lihat Daftar Transaksi</a>
                </div>                
                {{-- Modal Hasil Pencarian --}}
                @if($keyword)
                <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Hasil Pencarian Barang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if($barang->isEmpty())
                                    <p>Barang tidak ditemukan...</p>
                                @else
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($barang as $item)
                                                <tr>
                                                    <td>{{ $item->id_barang }}</td>
                                                    <td>{{ $item->nama_barang }}</td>
                                                    <td>Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                    <td>
                                                        <form method="POST" action="{{ route('penjualan.tambah') }}">
                                                            @csrf
                                                            <input type="hidden" name="id_barang" value="{{ $item->id_barang }}">
                                                            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required min="1">
                                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- Panel Keranjang --}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-shopping-cart"></i> Keranjang Penjualan</h4>
                            </div>
                            <div class="panel-body">
                                @if(empty($keranjang))
                                    <p>Keranjang masih kosong. Silakan tambahkan barang.</p>
                                @else
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($keranjang as $item)
                                                <tr>
                                                    <td>{{ $item['id_barang'] }}</td>
                                                    <td>{{ $item['nama_barang'] }}</td>
                                                    <td>{{ $item['jumlah'] }}</td>
                                                    <td>Rp. {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                                                    <td>Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
                                                    <td>
                                                        <form method="POST" action="{{ route('penjualan.update', $item['id_barang']) }}">
                                                            @csrf
                                                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" class="form-control" min="1">
                                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('penjualan.delete.barang', $item['id_barang']) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Total Keseluruhan:</th>
                                                <th colspan="2">
                                                    Rp. {{ number_format(array_sum(array_column($keranjang, 'total')), 0, ',', '.') }}
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('penjualan.cetak') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="total">Total Keseluruhan:</label>
                                            <input type="text" id="total" value="Rp. {{ number_format(array_sum(array_column(session('keranjang', []), 'total')), 0, ',', '.') }}" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="bayar">Bayar:</label>
                                            <input type="number" id="bayar" name="bayar" class="form-control" placeholder="Masukkan jumlah pembayaran" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kembalian">Kembalian:</label>
                                            <input type="text" id="kembalian" class="form-control" readonly>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Cetak Pembayaran</button>
                                        <a href="{{ route('penjualan.reset') }}" class="btn btn-warning">Reset Keranjang</a>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</section>
@endsection
<script>
   document.addEventListener('DOMContentLoaded', function () {
        const keyword = "{{ $keyword ?? '' }}";
        if (keyword.trim() !== "") {
            $('#searchModal').modal('show');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const bayarInput = document.getElementById('bayar');
        const totalInput = document.getElementById('total');
        const kembalianInput = document.getElementById('kembalian');

        bayarInput.addEventListener('input', function () {
            const total = parseInt(totalInput.value.replace(/[^\d]/g, '')) || 0;
            const bayar = parseInt(bayarInput.value) || 0;

            const kembalian = bayar - total;
            kembalianInput.value = kembalian > 0 ? `Rp. ${kembalian.toLocaleString('id-ID')}` : 'Rp. 0';
        });
    });
</script>
