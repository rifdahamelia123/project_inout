<?php

namespace App\Exports;

use App\Models\BarangMasuk; // Pastikan Anda menggunakan model yang benar
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LogMasukExport implements FromCollection, WithHeadings, WithMapping
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
        return BarangMasuk::when($this->bulan && $this->tahun, function ($query) {
            $query->whereMonth('created_at', $this->bulan)
                  ->whereYear('created_at', $this->tahun);
        })->select('kode_barang', 'nama_barang', 'stok', 'masuk', 'stok_akhir', 'nama_penerima', 'departemen', 'created_at')
          ->get()->map(function ($barang) {
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
            'Kuantitas Masuk',
            'Stok Akhir',
            'Nama Penerima',
            'Departemen',
            'Tanggal',
        ];
    }

    // Mapping data ke setiap baris di Excel
    public function map($barangMasuk): array
    {
        return [
            $barangMasuk->kode_barang,
            $barangMasuk->nama_barang,
            $barangMasuk->stok,
            $barangMasuk->masuk,
            $barangMasuk->stok_akhir,
            $barangMasuk->nama_penerima,
            $barangMasuk->departemen,
            Carbon::parse($barangMasuk->created_at)->format('Y-m-d'), // Pastikan menggunakan created_at
        ];
    }
}
