<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <p>Bulan: {{ $bulan }}</p>
    <p>Tahun: {{ $tahun }}</p>

    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->tanggal_penjualan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
