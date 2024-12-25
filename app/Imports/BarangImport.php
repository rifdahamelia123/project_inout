<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class BarangImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        return new Barang([
            'kode_barang'   => $row[0],   
            'nama_barang'   => $row[1],   
            'ukuran'        => $row[2]?? null,  
            'satuan'        => $row[3],   
            'concatenate_c_and_d' => $row[4], 
            'upper_description'   => $row[5], 
            'upper_uom'     => $row[6],  
            'stok'          => $row[11]?? null,
            'tanggal'       => now(),  
            'min'           => $row[7]?? null,
            'max'           => $row[8]?? null,
            'uom'           => $row[3]?? null,
            'in'            => $row[9]?? null,
            'out'           => $row[10]?? null,
            'remark'        => $row[12]?? null,
            'order_qty'     => $row[13]?? null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}