<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';

    protected $fillable = ['id_penjualan', 'id_barang', 'jumlah', 'total'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
