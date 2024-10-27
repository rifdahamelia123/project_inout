<?php

namespace App\Imports;

use App\Models\DashboardSimpadu;
use Maatwebsite\Excel\Concerns\ToModel;

class DashboardSimpaduImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DashboardSimpadu([
            'kode_barang' => $row[0],
            'nama_barang' => $row[1],
            'uom' => $row[2],
            'min' => $row[3]?? 0,
            'max' => $row[4]?? 0,
            'in' => $row[5] ?? 0,  // Berikan nilai default 0 jika kosong
            'out' => $row[6] ?? 0,
            'stok' => $row[7] ?? 0,
            'remark' => $row[8]?? 0,
            'order_qty' => $row[9] ?? 0,
        ]);
    }
}
