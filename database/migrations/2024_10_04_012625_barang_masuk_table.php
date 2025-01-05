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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id('id_barang_masuk');
            $table->unsignedBigInteger('id_kategori_barang');
            $table->string('kode_barang', 10);
            $table->string('nama_barang');
            $table->string(column: 'sumber_barang');
            $table->integer('jumlah_masuk');
            $table->string('kondisi');
            $table->unsignedBigInteger('id_lokasi');
            $table->date('tanggal_masuk');
            $table->timestamps();

            $table->foreign('id_kategori_barang')->references('id_kategori_barang')->on('kategori_barang')->onDelete('cascade');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};