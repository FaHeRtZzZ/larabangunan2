<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\StoreSettingController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanPenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit');


Route::middleware('auth', 'role:admin')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.update-password');    
    Route::get('/store-settings', [StoreSettingController::class, 'index'])->name('store-settings.index');
    Route::post('/store-settings', [StoreSettingController::class, 'update'])->name('store-settings.update');


    //Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/download', [BarangController::class, 'download'])->name('barang.download'); // Pastikan ini benar
    //Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    //Penjual
    Route::get('/penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan/tambah', [PenjualanController::class, 'tambah'])->name('penjualan.tambah');
    // Rute untuk memperbarui data penjualan berdasarkan ID
    Route::post('/penjualan/bayar', [PenjualanController::class, 'bayar'])->name('penjualan.bayar');
    Route::post('/penjualan/cetak', [PenjualanController::class, 'cetakPembayaran'])->name('penjualan.cetak');
    Route::get('/penjualan/reset', [PenjualanController::class, 'resetKeranjang'])->name('penjualan.reset');
    Route::post('/penjualan/update/{id_barang}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::post('/penjualan/delete/{id_barang}', [PenjualanController::class, 'delete'])->name('penjualan.delete.barang');
    Route::delete('/penjualan/{id_penjualan}', [PenjualanController::class, 'deletePenjualan'])->name('penjualan.delete.penjualan');
    Route::get('/laporan/penjualan', [PenjualanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan/penjualan/download', [PenjualanController::class, 'downloadLaporan'])->name('laporan.penjualan.download');
    Route::delete('/laporan/penjualan/{id}', [PenjualanController::class, 'hapusLaporan'])->name('laporan.penjualan.hapus');
    Route::get('/penjualan/daftar', [PenjualanController::class, 'daftar'])->name('penjualan.daftar');
    



});

