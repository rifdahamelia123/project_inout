<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('barang_masuk', function (Blueprint $table) {
        $table->integer('stok_akhir')->after('masuk');
    });
    }

    public function down()
    {
    Schema::table('barang_masuk', function (Blueprint $table) {
        $table->dropColumn('stok_akhir');
    });
    }

};
