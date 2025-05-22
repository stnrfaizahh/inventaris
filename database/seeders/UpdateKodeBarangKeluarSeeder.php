<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateKodeBarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Ambil semua data barang_keluar yang belum punya kode_barang_keluar
        $barangKeluarList = DB::table('barang_keluar')
            ->whereNull('kode_barang_keluar')
            ->get();

        foreach ($barangKeluarList as $bk) {
            // Ambil kode_barang dari tabel barang berdasarkan id_barang
            $barang = DB::table('barang')->where('id_barang', $bk->id_barang)->first();

            // Pastikan barang ditemukan dan memiliki kode_barang
            if ($barang && $barang->kode_barang) {
                $kodeBarangKeluar = $barang->kode_barang . '-' . $bk->id_lokasi;

                // Update kolom kode_barang_keluar
                DB::table('barang_keluar')
                    ->where('id_barang_keluar', $bk->id_barang_keluar)
                    ->update(['kode_barang_keluar' => $kodeBarangKeluar]);
            }
        }
    }
}