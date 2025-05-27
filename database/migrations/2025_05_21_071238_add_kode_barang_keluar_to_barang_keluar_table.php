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
        Schema::table('barang_keluar', function (Blueprint $table) {
        $table->unsignedBigInteger('id_barang')->nullable()->after('id_kategori_barang');
        $table->string('kode_barang_keluar')->nullable()->after('nama_penanggungjawab');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->dropColumn('kode_barang_keluar');
        });
    }
};