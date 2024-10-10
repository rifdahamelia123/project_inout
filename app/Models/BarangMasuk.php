<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    // Specify the table name
    protected $table = 'barang_masuk';

    // Specify the primary key
    protected $primaryKey = 'id';

    // The primary key is auto-incrementing
    public $incrementing = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
         'kode_barang', 
         'nama_barang', 
         'stok', 
         'masuk', 
         'stok_akhir'
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Timestamps
    public $timestamps = true;
}
