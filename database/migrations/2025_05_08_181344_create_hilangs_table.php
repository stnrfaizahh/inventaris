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
        Schema::create('hilangs', function (Blueprint $table) {
            $table->id('id_hilang');
            $table->unsignedBigInteger('id_barang_keluar');
            $table->integer('jumlah_hilang');
            $table->date('tanggal_hilang');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_barang_keluar')->references('id_barang_keluar')->on('barang_keluar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hilang');
    }
};