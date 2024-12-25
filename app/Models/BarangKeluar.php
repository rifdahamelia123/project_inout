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
        'concatenate_c_and_d', 
        'upper_description',
        'upper_uom',
        'uom',
        'stok',
        'keluar',
        'stok_akhir',
        'nama_penerima',
        'departemen',
        'jabatan',
        'keperluan',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

   
    // Timestamps
    public $timestamps = true;

  
    
}
