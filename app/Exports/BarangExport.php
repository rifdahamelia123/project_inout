<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;

class BarangExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BarangMasuk::all();
    }

    // Menambahi header di Excel
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Stok',
            'Masuk',
            'Stok_akhir',
            'Created At',
            'Updated At'
        ];
    }
}
