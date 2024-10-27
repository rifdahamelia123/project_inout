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
        'uom',
        'kuantitas',
        'tanggal',
        'nama_penerima',
        'departemen'
    ];
    

    // Timestamps
    public $timestamps = true;
}
