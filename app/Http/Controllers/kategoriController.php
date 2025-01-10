<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Carbon\Carbon;

class kategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
{
    // Ambil data kategori dengan pagination, 10 item per halaman
    $kategori = Kategori::paginate(10);

    // Kirim data ke view
    return view('kategori.index', compact('kategori'));
}


    // Menyimpan data kategori baru
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kategori' => 'required|string|max:255',
    ]);

    // Masukkan data ke database
    Kategori::create([
        'nama_kategori' => $request->kategori,
        'tgl_input' => now(), // Gunakan helper Laravel untuk waktu saat ini
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('kategori.index')->with('success', 'Tambah Data Berhasil!');
}

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id); // Ambil data berdasarkan ID
        return view('kategori.edit', compact('kategori'));
    }

    // Memperbarui data kategori
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        // Cari data berdasarkan ID dan update
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->kategori,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Update Data Berhasil!');
    }

    // Menghapus data kategori
    public function destroy($id)
{
    // Cari data kategori berdasarkan ID
    $kategori = Kategori::findOrFail($id);

    // Cek apakah kategori masih digunakan di tabel barang
    if ($kategori->barang()->count() > 0) {
        // Jika masih digunakan, kembalikan pesan error
        return redirect()->route('kategori.index')->with('remove', 'Kategori tidak dapat dihapus karena terkait dengan data lain. Hapus Data di Menu -> Barang.');
    }

    // Jika tidak ada data terkait, hapus kategori
    $kategori->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('kategori.index')->with('success', 'Hapus Data Berhasil!');
}

}
