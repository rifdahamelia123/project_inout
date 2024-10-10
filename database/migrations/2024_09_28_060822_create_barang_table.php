<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang');
            $table->char('nama_barang',);
            $table->integer('stok');
            $table->DateTime('tanggal_waktu');
            $table->timestamps(); // Optional: for created_at and updated_at columns

            $table->unique(['kode_barang', 'nama_barang']); // Tambahkan unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
