<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UpdateTransaksiWithBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Ambil semua barang master
         $barangs = DB::table('barang')->get();

         foreach ($barangs as $barang) {
             // Update barang_masuk
             DB::table('barang_masuk')
                 ->where('nama_barang', $barang->nama_barang)
                 ->update(['id_barang' => $barang->id_barang]);
 
             // Update barang_keluar
             DB::table('barang_keluar')
                 ->where('nama_barang', $barang->nama_barang)
                 ->update(['id_barang' => $barang->id_barang]);
 
             // Update barang_hilang (jika ada)
            //  if (Schema::hasTable('barang_hilang')) {
            //      DB::table('barang_hilang')
            //          ->where('nama_barang', $barang->nama_barang)
            //          ->update(['id_barang' => $barang->id_barang]);
            //  }
         }
 
         echo "Berhasil mengupdate id_barang berdasarkan nama_barang di semua transaksi.\n";
    }
}