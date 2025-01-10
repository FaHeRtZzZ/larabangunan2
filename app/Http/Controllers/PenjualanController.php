<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\LaporanPenjualan;
use Barryvdh\DomPDF\Facade\PDF;
class PenjualanController extends Controller
{
    public function index(Request $request)
{
    $barang = collect(); // Default-nya kosong
    $keyword = $request->input('keyword');
    if ($keyword) {
        $barang = Barang::where('id_barang', 'like', "%$keyword%")
            ->orWhere('nama_barang', 'like', "%$keyword%")
            ->get();
    }

    // Ambil keranjang dari sesi
    $keranjang = session('keranjang', []); 

    return view('transaksi.penjualan', compact('barang', 'keyword', 'keranjang'));
}



public function tambah(Request $request)
{
    $id_barang = $request->input('id_barang');
    $jumlah = $request->input('jumlah');

    $barang = Barang::find($id_barang);
    if (!$barang) {
        return redirect()->route('penjualan.index')->with('error', 'Barang tidak ditemukan.');
    }

    // Cek apakah jumlah yang diminta melebihi stok yang tersedia
    if ($jumlah > $barang->stok) {
        return redirect()->route('penjualan.index')->with('error', 'Stok tidak mencukupi. Tersedia hanya ' . $barang->stok . ' item.');
    }

    // Ambil keranjang dari sesi
    $keranjang = session('keranjang', []);

    // Hitung total jumlah barang yang sudah ada di keranjang (jika ada)
    $jumlahDiKeranjang = isset($keranjang[$id_barang]) ? $keranjang[$id_barang]['jumlah'] : 0;
    
    // Cek apakah total jumlah (di keranjang + yang baru ditambahkan) melebihi stok
    if ($jumlahDiKeranjang + $jumlah > $barang->stok) {
        return redirect()->route('penjualan.index')->with('error', 'Total jumlah di keranjang melebihi stok yang tersedia. Tersisa ' . ($barang->stok - $jumlahDiKeranjang) . ' item.');
    }

    // Tambahkan barang ke keranjang
    if (isset($keranjang[$id_barang])) {
        $keranjang[$id_barang]['jumlah'] += $jumlah;
        $keranjang[$id_barang]['total'] = $keranjang[$id_barang]['jumlah'] * $barang->harga_jual;
    } else {
        $keranjang[$id_barang] = [
            'id_barang' => $barang->id_barang,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $jumlah,
            'harga_jual' => $barang->harga_jual,
            'total' => $jumlah * $barang->harga_jual,
        ];
    }

    // Simpan keranjang ke sesi
    session(['keranjang' => $keranjang]);

    return redirect()->route('penjualan.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
}




public function update(Request $request, $id_barang)
{
    $keranjang = session()->get('keranjang', []);

    if (!isset($keranjang[$id_barang])) {
        return redirect()->back()->with('error', 'Barang tidak ditemukan di keranjang.');
    }

    // Cari informasi barang dari database
    $barang = Barang::find($id_barang);
    
    // Update jumlah barang dan total harga
    $jumlah = $request->input('jumlah');
    if ($jumlah <= 0) {
        return redirect()->back()->with('error', 'Jumlah barang tidak valid.');
    }

    // Cek apakah jumlah yang diminta melebihi stok
    if ($jumlah > $barang->stok) {
        return redirect()->back()->with('error', 'Stok tidak mencukupi. Tersedia hanya ' . $barang->stok . ' item.');
    }

    $keranjang[$id_barang]['jumlah'] = $jumlah;
    $keranjang[$id_barang]['total'] = $jumlah * $keranjang[$id_barang]['harga_jual'];

    // Simpan kembali ke session
    session()->put('keranjang', $keranjang);

    return redirect()->back()->with('success', 'Jumlah barang berhasil diperbarui.');
}



public function delete($id_barang)
{
    $keranjang = session()->get('keranjang', []);

    if (!isset($keranjang[$id_barang])) {
        return redirect()->back()->with('error', 'Barang tidak ditemukan di keranjang.');
    }

    // Hapus barang dari keranjang
    unset($keranjang[$id_barang]);

    // Simpan kembali ke session
    session()->put('keranjang', $keranjang);

    return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang.');
}

public function deletePenjualan($id_penjualan)
{
    // Find the penjualan record
    $penjualan = Penjualan::find($id_penjualan);

    if (!$penjualan) {
        return redirect()->back()->with('error', 'Penjualan tidak ditemukan.');
    }

    // Delete the penjualan
    $penjualan->delete();

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
}


    public function bayar(Request $request)
    {
        $penjualan = session('penjualan', []);

        if (empty($penjualan)) {
            return redirect()->route('penjualan.index')->with('remove', 'Keranjang kosong, tidak bisa melakukan pembayaran.');
        }

        $total = array_sum(array_column($penjualan, 'total'));

        // Validasi pembayaran
        $bayar = $request->input('bayar');
        if ($bayar < $total) {
            return redirect()->route('penjualan.index')->with('remove', 'Jumlah pembayaran kurang.');
        }

        // Simpan transaksi atau logika lainnya
        session()->forget('penjualan'); // Reset keranjang setelah pembayaran

        return redirect()->route('penjualan.index')->with('success', 'Pembayaran berhasil. Kembalian: Rp. ' . number_format($bayar - $total, 0, ',', '.'));
    }
    public function cetakPembayaran(Request $request)
{
    $keranjang = session('keranjang', []);

    if (empty($keranjang)) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

    $totalBayar = array_sum(array_column($keranjang, 'total'));

    // Validasi pembayaran
    if ($request->bayar < $totalBayar) {
        $kurang = $totalBayar - $request->bayar;
        return redirect()->back()->with('error', 'Pembayaran tidak mencukupi! Anda kekurangan Rp. ' . number_format($kurang, 0, ',', '.'));
    }

    $kembalian = $request->bayar - $totalBayar;

    foreach ($keranjang as $item) {
        $barang = Barang::findOrFail($item['id_barang']);

        // Perbarui stok dan jumlah terjual
        $barang->stok -= $item['jumlah'];
        $barang->terjual += $item['jumlah'];
        $barang->save();

        // Simpan data penjualan
        $penjualan = Penjualan::create([
            'id_barang' => $item['id_barang'],
            'jumlah' => $item['jumlah'],
            'total' => $item['total'],
        ]);

        // Simpan data ke tabel laporan penjualan
        LaporanPenjualan::create([
            'id_penjualan' => $penjualan->id_penjualan,
            'id_barang' => $item['id_barang'],
            'nama_barang' => $item['nama_barang'],
            'jumlah' => $item['jumlah'],
            'harga_satuan' => $item['harga_jual'],
            'total' => $item['total'],
            'tanggal_penjualan' => now(),
        ]);
    }

    // Hapus keranjang setelah transaksi berhasil
    session()->forget('keranjang');

    // Data untuk struk PDF
    $data = [
        'keranjang' => $keranjang,
        'totalBayar' => $totalBayar,
        'bayar' => $request->bayar,
        'kembalian' => $kembalian,
        'tanggal' => now()->format('d-m-Y H:i'),
    ];

    // Generate PDF
    $pdf = PDF::loadView('transaksi.struk', $data);

    // Kembalikan file PDF sebagai download
    return $pdf->download('struk_pembayaran.pdf');
}

public function resetKeranjang()
{
    // Hapus keranjang dari sesi
    session()->forget('keranjang');

    return redirect()->route('penjualan.index')->with('success', 'Keranjang telah direset.');
}
public function laporanPenjualan(Request $request)
{
    $query = LaporanPenjualan::query();

    // Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_penjualan', $request->bulan);
    }

    // Filter berdasarkan tahun
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_penjualan', $request->tahun);
    }

    // Menggunakan pagination
    $laporan = $query->orderBy('tanggal_penjualan', 'desc')->paginate(10); // 10 items per page

    return view('laporan.penjualan', compact('laporan'));
}


public function simpanKeLaporan($penjualan)
{
    foreach ($penjualan->items as $item) {
        LaporanPenjualan::create([
            'id_penjualan' => $penjualan->id_penjualan,
            'id_barang' => $item->id_barang,
            'nama_barang' => $item->barang->nama_barang,
            'jumlah' => $item->jumlah,
            'harga_satuan' => $item->barang->harga,
            'total' => $item->jumlah * $item->barang->harga,
            'tanggal_penjualan' => $penjualan->tanggal_penjualan,
        ]);
    }
}

public function hapusLaporan($id)
{
    $laporan = LaporanPenjualan::findOrFail($id);
    $laporan->delete();

    return redirect()->route('laporan.penjualan')->with('success', 'Laporan berhasil dihapus.');
}



public function downloadLaporan(Request $request)
{
    $query = LaporanPenjualan::query();

    // Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_penjualan', $request->bulan);
    }

    // Filter berdasarkan tahun
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_penjualan', $request->tahun);
    }

    $laporan = $query->orderBy('tanggal_penjualan', 'desc')->get();

    $data = [
        'laporan' => $laporan,
        'bulan' => $request->bulan ? date('F', mktime(0, 0, 0, $request->bulan, 1)) : 'Semua',
        'tahun' => $request->tahun ?? 'Semua',
    ];

    $pdf = PDF::loadView('laporan.pdf', $data);

    return $pdf->download('laporan_penjualan.pdf');
}

//view daftar penjualan

public function daftar(Request $request)
{
    $keyword = $request->input('keyword');
    $penjualan = Penjualan::query()
        ->when($keyword, function ($query) use ($keyword) {
            $query->where('id_penjualan', 'like', "%{$keyword}%")
                  ->orWhereHas('barang', function ($query) use ($keyword) {
                      $query->where('nama_barang', 'like', "%{$keyword}%");
                  });
        })
        ->paginate(10);

    return view('transaksi.daftar_penjualan', compact('penjualan', 'keyword'));
}

}
