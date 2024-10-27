<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat data dummy untuk tabel barang_keluar
        $data = [
            [
                'kode_barang' => 'A-001',
                'nama_barang' => strtoupper('kertas hvs'),
                'uom' => strtoupper('Rim/Box'),
                'kuantitas' => 10,
                'tanggal' => '2024-04-18',
                'nama_penerima' => 'rifdah',
                'departemen' => strtoupper('coe'), 
                'jabatan' => 'magang IT',
                'keperluan' => 'office'
            ],
        ];

        // Masukkan data ke dalam tabel
        DB::table('barang_keluar')->insert($data);
    }
}
