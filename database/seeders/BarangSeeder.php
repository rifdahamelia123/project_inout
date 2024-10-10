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
        // Buat data dummy untuk tabel barang
        $data = [
            [
                'kode_barang' => 'C001',
                'nama_barang' => 'Mouse',
                'stok' => 100,
                'tanggal_waktu' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'C002',
                'nama_barang' => 'Leptop',
                'stok' => 50,
                'tanggal_waktu' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        // Masukkan data ke dalam tabel menggunakan DB::table
        DB::table('barang')->insert($data);
    }
}
