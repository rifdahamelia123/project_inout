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
                'kode_barang' => '1',
                'nama_barang' => 'Barang Keluar 1',
                'tanggal_waktu' => now(),
                'kuantitas' => 10,
                'user' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '2',
                'nama_barang' => 'Barang Keluar 2',
                'tanggal_waktu' => now(),
                'kuantitas' => 5,
                'user' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        // Masukkan data ke dalam tabel menggunakan DB::table
        //DB::table('barang_keluar')->insert($data);
    }
}
