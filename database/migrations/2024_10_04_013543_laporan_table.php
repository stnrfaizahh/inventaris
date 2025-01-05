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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->integer('periode_bulan');
            $table->integer('periode_tahun');
            $table->date('tanggal_cetak');
            $table->string('pencetak'); // Nama admin yang mencetak laporan
            $table->string('file_laporan')->nullable(); // lap akan disimpan di server
            $table->text('keterangan')->nullable(); // Informasi tambahan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};