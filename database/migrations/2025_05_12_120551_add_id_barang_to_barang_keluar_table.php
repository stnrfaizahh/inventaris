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
        $table->unsignedBigInteger('id_barang')->after('id_kategori_barang')->nullable();

        $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
            $table->dropColumn('id_barang');
        });
    }
};