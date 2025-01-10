<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    protected $fillable = [
        'id_toko',
        'nama_toko', 
        'alamat_toko', 
        'tlp', 
        'nama_pemilik',
    ];

    
}
