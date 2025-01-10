@extends('layouts.app')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-9">
                <div class="row mx-3">
                    <h1>
                        <img src="{{ asset('assets/img/Icon.png') }}" height="50" width="50" alt="Logo">
                        DASHBOARD
                    </h1>
                    <hr>

                    @if($stokBarang->isNotEmpty())
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                Stok barang berikut sudah kurang
                                <ul>
                                    @foreach($stokBarang as $barang)
                                        <li>{{ $barang->nama_barang }} ({{ $barang->stok }})</li>
                                    @endforeach
                                </ul>
                                <span class="float-end">
                                    <a href="{{ route('barang') }}">Tabel Barang <i class="fa fa-arrow-right"></i></a>
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <!-- STATUS PANELS -->
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">Jumlah Barang</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 80px; height: 80px;">
                                            <i class="fa fa-cubes text-primary" style="font-size: 36px;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="text-dark">{{ $jumlahBarang }}</h6>
                                            <a href="{{ route('barang') }}" class="text-dark small">Tabel Barang <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">Stok Barang</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 80px; height: 80px;">
                                            <i class="fa fa-box-open text-success" style="font-size: 36px;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="text-dark">{{ $stokTersedia }}</h6>
                                            <a href="{{ route('barang') }}" class="text-dark small">Tabel Barang <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">Telah Terjual</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 80px; height: 80px;">
                                            <i class="fa fa-shopping-cart text-info" style="font-size: 36px;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="text-dark">{{ $jumlahTerjual }}</h6>
                                            <a href="{{ route('laporan.penjualan') }}" class="text-dark small">Tabel Laporan <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">Kategori Barang</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 80px; height: 80px;">
                                            <i class="fa fa-tags text-danger" style="font-size: 36px;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="text-dark">{{ $jumlahKategori }}</h6>
                                            <a href="{{ route('kategori.index') }}" class="text-dark small">Tabel Kategori <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Row -->
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
