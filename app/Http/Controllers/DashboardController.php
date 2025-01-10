<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data yang dibutuhkan dari database
        $jumlahBarang = Barang::count();
        $stokBarang = Barang::where('stok', '<=', 3)->get();
        $stokTersedia = Barang::sum('stok');
        $jumlahTerjual = Barang::sum('terjual'); // Asumsikan ada kolom 'terjual'
        $jumlahKategori = Kategori::count();

        return view('dashboard', compact(
            'jumlahBarang',
            'stokBarang',
            'stokTersedia',
            'jumlahTerjual',
            'jumlahKategori'
        ));
    }
}