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
    public $incrementing = false; 
    protected $keyType = 'integer';


    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'ukuran',
        'satuan',
        'concatenate_c_and_d',
        'upper_description',
        'upper_uom',
        'stok',
        'tanggal',
    ];

     // Mutator untuk concatenate_c_and_d
     public function setConcatenateCAndDAttribute($value)
     {
         $this->attributes['concatenate_c_and_d'] = ($this->nama_barang . ' ' . $this->ukuran);
     }
 
     // Mutator untuk upper_uom
     public function setUpperUomAttribute($value)
     {
         $this->attributes['upper_uom'] = strtoupper($this->satuan);
     }
    
    
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class); 

    }
}

