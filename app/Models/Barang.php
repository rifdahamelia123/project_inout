<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;

class Barang extends Model
{
    
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false; // Because kode_barang is not an auto-incrementing primary key
    protected $keyType = 'integer';


    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'tanggal_waktu',
        'stok',
    ];
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class); 

    }
}

