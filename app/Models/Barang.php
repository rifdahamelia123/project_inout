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
        'uom',
        'min',
        'max',
        'in',
        'out',
        'remark',
        'order_qty',
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



     public function getRemarkAttribute()
     {
         return $this->stok < $this->min ? 'Order' : 'Aman';
     }

     public function getOrderQtyAttribute()
     {
         if ($this->stok < $this->min) {
             // Jika stok di bawah minimum, hitung order qty sebagai stok - min
             return $this->stok - $this->min; // Ini akan menghasilkan nilai positif
         } elseif ($this->stok >= $this->max) {
             // Jika stok sama dengan atau di atas maksimum, hitung order qty sebagai stok - max
             return $this->stok - $this->max; // Ini akan menghasilkan nilai negatif
         } else {
             // Jika stok berada di antara min dan max, tidak ada order yang diperlukan
             return 0; // Ini akan menghasilkan nilai 0
         }
     }



    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
    public function dashboardInout()
    {
        return $this->hasOne(dashboardInout::class, 'kode_barang', 'kode_barang');
    }
}

