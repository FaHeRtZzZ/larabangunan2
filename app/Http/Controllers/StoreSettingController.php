<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreSetting;

class StoreSettingController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengaturan toko
        $storeSetting = StoreSetting::first(); // Mengambil data pertama dari tabel 'toko'
        return view('store-settings.index', compact('storeSetting')); // Mengirim data ke view
    }
    public function update(Request $request)
    {
        // Validasi input data
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string',
            'tlp' => 'required|string',
            'nama_pemilik' => 'required|string',
        ]);
    
        // Cari data toko berdasarkan id_toko
        $store = StoreSetting::find($request->id_toko);
    
        if ($store) {
            // Mengupdate data toko menggunakan save()
            $store->nama_toko = $request->input('nama_toko');
            $store->alamat_toko = $request->input('alamat_toko');
            $store->tlp = $request->input('tlp');
            $store->nama_pemilik = $request->input('nama_pemilik');
            
            // Menyimpan perubahan ke database
            $store->save();
    
            // Redirect dengan pesan sukses
            return redirect()->route('store-settings.index')->with('success', 'Data berhasil diperbarui.');
        } else {
            // Jika toko tidak ditemukan
            return redirect()->route('store-settings.index')->with('error', 'Toko tidak ditemukan.');
        }
    }
    


}
