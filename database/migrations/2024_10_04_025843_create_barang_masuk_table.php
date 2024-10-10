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
            $table->integer('stok');
            $table->integer('masuk');
            $table->integer('stok_akhir')->default(0)->change();
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }


};
