<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\PDF;

class BarangController extends Controller
{
    // Menampilkan semua barang
    public function index(Request $request)
{
    $query = Barang::with('kategori');

    // Cek apakah ada keyword pencarian
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where('nama_barang', 'like', "%$keyword%")
              ->orWhere('merk', 'like', "%$keyword%")
              ->orWhereHas('kategori', function ($q) use ($keyword) {
                  $q->where('nama_kategori', 'like', "%$keyword%");
              });
    }

    // Gunakan paginate untuk menambahkan pagination
    $barang = $query->paginate(10);

    return view('barang.index', compact('barang'));
}


    // Menampilkan form untuk menambahkan barang
    public function create()
    {
        $kategori = Kategori::all(); // Mengambil semua kategori
        return view('barang.create', compact('kategori'));
    }

    // Menyimpan barang baru ke database
    public function store(Request $request)
{
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'merk' => 'required|string|max:255',
        'harga_beli' => 'required|integer',
        'harga_jual' => 'required|integer',
        'stok' => 'required|integer',
        'satuan_barang' => 'required|string|max:50',
        'id_kategori' => 'required|exists:kategori,id_kategori',
    ]);

    // Generate ID Barang unik berbasis angka
    $lastId = Barang::orderByRaw('CAST(id_barang AS UNSIGNED) DESC')->value('id_barang'); // Ambil ID tertinggi
    $newId = $lastId ? intval($lastId) + 1 : 1; // Konversi ke integer, lalu tambahkan 1

    // Simpan barang baru
    Barang::create([
        'id_barang' => $newId, // ID barang baru
        'nama_barang' => $request->nama_barang,
        'merk' => $request->merk,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'stok' => $request->stok,
        'satuan_barang' => $request->satuan_barang,
        'id_kategori' => $request->id_kategori,
    ]);

    return redirect()->route('barang')->with('success', 'Barang berhasil ditambahkan!');
}


    // Menampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::where('id_barang', $id)->firstOrFail(); // Ambil barang berdasarkan ID
        $kategori = Kategori::all(); // Mengambil semua kategori
        return view('barang.edit', compact('barang', 'kategori'));
    }

    // Memperbarui data barang
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'satuan_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:kategori,id_kategori',
        ]);

        // Mengambil data barang berdasarkan ID
        $barang = Barang::where('id_barang', $id)->firstOrFail();

        // Update data barang
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'merk' => $request->merk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'satuan_barang' => $request->satuan_barang,
            'id_kategori' => $request->id_kategori,
        ]);

        // Redirect ke halaman barang dengan pesan sukses
        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui');
    }

    // Menghapus barang
    public function destroy($id)
    {
        try {
            Barang::where('id_barang', $id)->delete();
            return redirect()->route('barang')->with('success', 'Barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('barang')->with('error', 'Barang tidak dapat dihapus karena terkait dengan data lain.');
        }
    }

    // Mendownload data barang dalam format PDF
    public function download()
    {
        $barang = Barang::with('kategori')->get();

        // Data yang akan dikirim ke PDF
        $data = [
            'barang' => $barang,
        ];

        // Generate PDF menggunakan view barang.pdf
        $pdf = PDF::loadView('Barang.pdf', $data);

        return $pdf->download('data_barang.pdf');
    }
}
