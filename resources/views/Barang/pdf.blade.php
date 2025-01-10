<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
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
    <h1>Data Barang</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $b)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->merk }}</td>
                <td>Rp. {{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ $b->satuan_barang }}</td>
                <td>{{ $b->kategori->nama_kategori }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
