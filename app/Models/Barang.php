<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'id_barang',
        'id_kategori',
        'nama_barang',
        'merk',
        'harga_beli',
        'harga_jual',
        'satuan_barang',
        'stok',
        'terjual',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_barang');
    }
}
