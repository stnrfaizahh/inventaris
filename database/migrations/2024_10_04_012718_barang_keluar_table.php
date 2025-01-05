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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id('id_barang_keluar');
            $table->unsignedBigInteger('id_kategori_barang');
            $table->unsignedBigInteger('id_lokasi'); 
            $table->string('nama_barang');
            $table->integer('jumlah_keluar');
            $table->string('kondisi');
            $table->date('tanggal_keluar');
            $table->integer('masa_pakai');
            $table->date('tanggal_exp');
            $table->string('nama_penanggungjawab');
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
        Schema::dropIfExists('barang_keluar');
    }
};