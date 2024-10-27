<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardSimpadu extends Model
{
    use HasFactory;

    protected $table = 'dashboard-simpadu';

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
}
