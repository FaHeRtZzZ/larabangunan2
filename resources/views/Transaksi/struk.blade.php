<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    <h2>Struk Pembayaran</h2>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjang as $item)
                <tr>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp. {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Bayar</th>
                <td>Rp. {{ number_format($totalBayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Pembayaran</th>
                <td>Rp. {{ number_format($bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3">Kembalian</th>
                <td>Rp. {{ number_format($kembalian, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
