<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Barang;

class BarangKeluar extends Model
{
    // Specify the table name
    protected $table = 'barang_keluar';

    // Specify the primary key
    protected $primaryKey = 'id';

    // The primary key is auto-incrementing
    public $incrementing = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'kode_barang', 
        'nama_barang', 
        'stok', 
        'keluar', 
        'stok_akhir'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    // Timestamps
    public $timestamps = true;

  
    
}
