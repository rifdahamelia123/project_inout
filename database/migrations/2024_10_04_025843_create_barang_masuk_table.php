<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('ukuran')->nullable();
            $table->string('uom');
            $table->string('concatenate_c_and_d'); 
            $table->string('upper_description');
            $table->string('upper_uom');
            $table->integer('stok');
            $table->integer('masuk');
            $table->integer('stok_akhir');
            $table->string('nama_penerima');
            $table->string('departemen');
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }


};
