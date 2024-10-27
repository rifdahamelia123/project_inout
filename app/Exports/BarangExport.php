<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class BarangExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil data yang akan diekspor ke Excel.
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BarangMasuk::select('kode_barang', 'nama_barang', 'stok', 'masuk', 'stok_akhir', 'created_at')->get();
    }

    /**
     * Mapping data yang diekspor.
     * @param mixed $barang
     * @return array
     */
    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->stok,
            $barang->masuk,
            $barang->stok_akhir,
            Carbon::parse($barang->created_at)->format('Y-m-d'), // Format tanggal tanpa waktu
        ];
    }

    /**
     * Menentukan heading (judul kolom) pada file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Stok Awal',
            'Masuk',
            'Stok Akhir',
            'Tanggal', // Judul kolom untuk tanggal
        ];
    }
    
}
