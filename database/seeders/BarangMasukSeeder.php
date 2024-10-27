<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
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
                'nama_barang' => strtoupper('kertas hvs'),
                'uom' => strtoupper('Rim/Box'),
                'kuantitas' => 10,
                'tanggal' => '2024-04-18',
                'nama_penerima' => 'rifdah',
                'departemen' => strtoupper('coe'), 
            ],
        ];

        // Masukkan data ke dalam tabel
        DB::table('barang_masuk')->insert($data);
    }
}
