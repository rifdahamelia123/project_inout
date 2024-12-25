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
        Schema::create('dashboard_inout', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('uom')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->integer('stok');
            $table->string('remark')->default('Aman');
            $table->integer('order_qty')->default(0);
            $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_inout');
    }
};
