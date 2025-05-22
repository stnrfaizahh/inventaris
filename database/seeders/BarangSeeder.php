<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Str;


class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangMasukList = BarangMasuk::select('kode_barang', 'nama_barang', 'id_kategori_barang')
    ->distinct()
    ->get();
    foreach ($barangMasukList as $item) {
        Barang::updateOrCreate(
            ['kode_barang' => $item->kode_barang],
            [
                'nama_barang' => $item->nama_barang,
                'id_kategori_barang' => $item->id_kategori_barang,
                'barcode' => 'BRG-' . strtoupper(Str::random(8)),
            ]
        );
    }
    }
}