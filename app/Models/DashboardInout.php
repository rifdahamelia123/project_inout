<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardInout extends Model
{
    use HasFactory;

    protected $table = 'dashboard_inout';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'uom',
        'min',
        'max',
        'in',
        'out',
        'stok',
        'remark',
        'order_qty',
    ];

    public function getOrderQtyAttribute()
    {
        // Menghitung order quantity hanya jika stok saat ini kurang dari minimum
        return $this->stok < $this->min ? $this->min - $this->stok : 0;
    }
}

