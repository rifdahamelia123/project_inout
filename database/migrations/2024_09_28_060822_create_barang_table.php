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
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('satuan')->nullable();
            $table->string('concatenate_c_and_d'); 
            $table->string('upper_description');
            $table->string('upper_uom'); 
            $table->integer('stok')->nullable();
            $table->date('tanggal');
            $table->string('uom');
            $table->integer('min')->nullable();
            $table->string('max')->nullable();
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->string('remark')->nullable();
            $table->integer('order_qty')->nullable();
            $table->timestamps();
            
            //$table->unique(['kode_barang', 'nama_barang']);
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
