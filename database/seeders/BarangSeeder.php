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
                'uom' => strtoupper('Rim/Box'),
                'min' => 1,
                'max'=> 2,
                'in' => 100,
                'out' => 0,
                'remark' => 'AMAN',
                'order_qty' => -100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];
        
        // Masukkan data ke dalam tabel menggunakan DB::table
        DB::table('barang')->insert($data);
    }
    
}
