@extends('layouts.app')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12 main-chart">
                <h3>Pengaturan Toko</h3>
                <br>
                @if(session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
                @endif
                <form method="POST" action="{{ route('store-settings.update') }}">
                    @csrf
                    <input type="hidden" name="id_toko" value="{{ $storeSetting->id_toko }}"> <!-- Hidden input untuk id_toko -->
                    
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <td>Nama Toko</td>
                                <td>Alamat Toko</td>
                                <td>Kontak (Hp)</td>
                                <td>Nama Pemilik Toko</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-control" name="nama_toko" value="{{ old('nama_toko', $storeSetting->nama_toko) }}" placeholder="Nama Toko"></td>
                                <td><input class="form-control" name="alamat_toko" value="{{ old('alamat_toko', $storeSetting->alamat_toko) }}" placeholder="Alamat Toko"></td>
                                <td><input class="form-control" name="tlp" value="{{ old('tlp', $storeSetting->tlp) }}" placeholder="Kontak (Hp)"></td>
                                <td><input class="form-control" name="nama_pemilik" value="{{ old('nama_pemilik', $storeSetting->nama_pemilik) }}" placeholder="Nama Pemilik Toko"></td>
                                <td><button class="btn btn-primary"><i class="fa fa-pencil"></i> Update Data</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                
                <div class="clearfix" style="padding-top:41%;"></div>
            </div>
        </div>
    </section>
</section>
@endsection
