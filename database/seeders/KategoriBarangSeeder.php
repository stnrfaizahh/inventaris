<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriBarang;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriBarang::insert(values: [
            ['kode_kategori' => 'F', 'nama_kategori_barang' => 'Furniture'],
            ['kode_kategori' => 'P', 'nama_kategori_barang' => 'Perlengkapan'],
            ['kode_kategori' => 'PRT', 'nama_kategori_barang' => 'Peralatan Rumah Tangga'],
            ['kode_kategori' => 'EL', 'nama_kategori_barang' => 'Elektronik'],
            ['kode_kategori' => 'ATK', 'nama_kategori_barang' => 'ATK'],
        ]);
    }
}