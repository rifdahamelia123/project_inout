<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            [
                'kode_barang' => 'A-001',
                'nama_barang' => 'Kertas HVS',
                'ukuran' => 'A4',
                'satuan' => 'Rim/Box',
                'concatenate_c_and_d' => 'Kertas HVS A4',
                'upper_description' => strtoupper('Kertas HVS A4'),
                'upper_uom' => strtoupper('Rim/Box'),
                'stok' => 100,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];
        
        // Masukkan data ke dalam tabel menggunakan DB::table
        DB::table('barang')->insert($data);
    }
}
