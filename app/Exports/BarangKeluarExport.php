<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class BarangKeluarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;

    // Constructor for receiving 'bulan' (filter)
    public function __construct($bulan = null)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        // Memastikan bahwa bulan dipilih dari input form
        if ($this->bulan) {
            // Filter data berdasarkan bulan dan tahun
            return BarangKeluar::whereYear('tanggal', '=', \Carbon\Carbon::parse($this->bulan)->format('Y'))
                ->whereMonth('tanggal', '=', \Carbon\Carbon::parse($this->bulan)->format('m'))
                ->select('kode_barang', 'nama_barang', 'UOM', 'kuantitas', 'tanggal', 'nama_penerima', 'departemen', 'jabatan', 'keperluan')
                ->get();
        }
    
        // Jika bulan tidak dipilih, kembalikan semua data
        return BarangKeluar::select('kode_barang', 'nama_barang', 'UOM', 'kuantitas', 'tanggal', 'nama_penerima', 'departemen', 'jabatan', 'keperluan')->get();
    }
    
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'uom',
            'Kuantitas',
            'Tanggal',
            'Nama Penerima',
            'Departemen',
            'Jabatan',
            'Keperluan',
        ];
    }

    // Mapping data to each row in Excel
    public function map($barangKeluar): array
    {
        return [
            $barangKeluar->kode_barang,
            $barangKeluar->nama_barang,
            $barangKeluar->uom,
            $barangKeluar->kuantitas,
            Carbon::parse($barangKeluar->tanggal)->format('Y-m-d'), 
            $barangKeluar->nama_penerima,
            $barangKeluar->departemen,
            $barangKeluar->jabatan,
            $barangKeluar->keperluan,
        ];
    }
}
