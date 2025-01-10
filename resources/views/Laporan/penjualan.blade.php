@extends('layouts.app')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <h3>Laporan Penjualan</h3>
        
        {{-- Filter Laporan --}}
        <form action="{{ route('laporan.penjualan') }}" method="GET" class="form-inline mb-3">
            <div class="form-group">
                <label for="bulan" class="mr-2">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control mr-3">
                    <option value="">Semua</option>
                    @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tahun" class="mr-2">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control mr-3">
                    <option value="">Semua</option>
                    @foreach(range(date('Y') - 10, date('Y')) as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary ml-2">Reset</a>
        </form>

        {{-- Tombol Unduh Laporan --}}
        <form action="{{ route('laporan.penjualan.download') }}" method="GET" class="mt-3">
            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
            <button type="submit" class="btn btn-success">Unduh Laporan</button>
        </form>

        {{-- Tabel Laporan --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Tanggal Penjualan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $index => $item)
                    <tr>
                        {{-- Gunakan logika untuk nomor urut --}}
                        <td>
                            @if($laporan instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ ($laporan->currentPage() - 1) * $laporan->perPage() + $index + 1 }}
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d-m-Y') }}</td> {{-- Format tanggal --}}
                        <td>
                            <form action="{{ route('laporan.penjualan.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($laporan instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center">
                {{ $laporan->links() }}
            </div>
        @endif
    </section>
</section>
@endsection
