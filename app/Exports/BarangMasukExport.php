<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class BarangMasukExport implements FromCollection, WithHeadings, WithMapping
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
            return BarangMasuk::whereYear('tanggal', '=', Carbon::parse($this->bulan)->format('Y'))
                ->whereMonth('tanggal', '=', Carbon::parse($this->bulan)->format('m'))
                ->select('kode_barang', 'nama_barang', 'UOM', 'kuantitas', 'tanggal', 'nama_penerima', 'departemen')
                ->get();
        }
    
        // Jika bulan tidak dipilih, kembalikan semua data
        return BarangMasuk::select('kode_barang', 'nama_barang', 'UOM', 'kuantitas', 'tanggal', 'nama_penerima', 'departemen')->get();
    }
    
    // Define the headings of the Excel sheet
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'UOM',
            'Kuantitas',
            'Tanggal',
            'Nama Penerima',
            'Departemen',
        ];
    }

    // Mapping data to each row in Excel
    public function map($barangMasuk): array
    {
        return [
            $barangMasuk->kode_barang,
            $barangMasuk->nama_barang,
            $barangMasuk->UOM, // Ensure this field is correctly named
            $barangMasuk->kuantitas,
            Carbon::parse($barangMasuk->tanggal)->format('Y-m-d'), 
            $barangMasuk->nama_penerima,
            $barangMasuk->departemen,
        ];
    }
}
