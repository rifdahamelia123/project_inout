<?php

namespace App\Exports;

use App\Models\DashboardSimpadu;
use Maatwebsite\Excel\Concerns\FromCollection;


class DashboardSimpaduExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DashboardSimpadu::select('kode_barang','nama_barang','uom','min','max','in','out','stok','remark','order_qty',)->get();
    }
}
