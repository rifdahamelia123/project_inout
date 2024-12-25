<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardInoutExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Sesuaikan query dengan data yang digunakan pada tampilan dashboard
        return Barang::select('kode_barang', 'nama_barang', 'uom', 'min', 'max', 'in', 'out', 'stok', 'remark', 'order_qty')
                    ->get();
    }

    /**
     * Tentukan header untuk file Excel
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'UOM',
            'MIN',
            'MAX',
            'IN',
            'OUT',
            'STOK',
            'REMARK',
            'ORDER QTY'
        ];
    }
}
