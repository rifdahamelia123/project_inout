<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LogKeluarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    // Constructor untuk menerima 'bulan' dan 'tahun' (filter)
    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return BarangKeluar::when($this->bulan && $this->tahun, function ($query) {
            $query->whereMonth('created_at', $this->bulan)
                  ->whereYear('created_at', $this->tahun);
        })->select(
            'kode_barang', 'nama_barang', 'stok', 'keluar', 'stok_akhir', 'created_at', 'nama_penerima', 'departemen', 'jabatan', 'keperluan'
        )->get()->map(function ($barang) {
            $barang->created_at = Carbon::parse($barang->created_at)
                ->setTimezone('Asia/Makassar')
                ->format('Y-m-d H:i:s');
            return $barang;
        });
    }


    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Stok Awal',
            'Kuantitas Keluar',
            'Stok Akhir',
            'Tanggal',
            'Nama Penerima',
            'Departemen',
            'Jabatan',
            'Keperluan',
        ];
    }

    public function map($barangKeluar): array
    {
        return [
            $barangKeluar->kode_barang,
            $barangKeluar->nama_barang,
            $barangKeluar->stok,
            $barangKeluar->keluar,
            $barangKeluar->stok_akhir,
            Carbon::parse($barangKeluar->created_at)->format('Y-m-d'),
            $barangKeluar->nama_penerima,
            $barangKeluar->departemen,
            $barangKeluar->jabatan,
            $barangKeluar->keperluan,
        ];
    }

}

