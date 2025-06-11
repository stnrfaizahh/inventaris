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
            $table->id('id_barang');
            $table->unsignedBigInteger('id_kategori_barang');
            $table->string('kode_barang', 10)->unique(); // tetap gunakan format seperti sekarang
            $table->string('nama_barang');
            $table->string('barcode')->unique(); // kode barcode unik untuk 1 jenis barang
            $table->timestamps();
        
            $table->foreign('id_kategori_barang')->references('id_kategori_barang')->on('kategori_barang')->onDelete('cascade');
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