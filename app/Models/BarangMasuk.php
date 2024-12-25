<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'concatenate_c_and_d', 
        'upper_description',
        'upper_uom',
        'uom',
        'stok',
        'masuk',
        'stok_akhir',
        'nama_penerima',
        'departemen',
    ];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Timestamps
    public $timestamps = true;
}
