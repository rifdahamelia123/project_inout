<?php

namespace App\Imports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class BarangMasukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BarangMasuk([
            'kode_barang'    => $row[0],
            'nama_barang'    => $row[1],
            'uom'            => $row[2], 
            'kuantitas'      => $row[3] ?? null,
            'tanggal'        => is_numeric($row[4]) ? Carbon::instance(Date::excelToDateTimeObject($row[4])) : null,
            'nama_penerima'  => $row[5], 
            'departemen'     => $row[6],
        ]);

    }
}
