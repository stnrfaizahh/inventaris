<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasi')->insert([
            ['kode_lokasi' => 'KLS01A', 'nama_lokasi' => 'Kelas 1A'],
            ['kode_lokasi' => 'KLS01B', 'nama_lokasi' => 'Kelas 1B'],
            ['kode_lokasi' => 'KLS01C', 'nama_lokasi' => 'Kelas 1C'],
            ['kode_lokasi' => 'KLS01D', 'nama_lokasi' => 'Kelas 1D'],
            ['kode_lokasi' => 'KLS02A', 'nama_lokasi' => 'Kelas 2A'],
            ['kode_lokasi' => 'KLS02B', 'nama_lokasi' => 'Kelas 2B'],
            ['kode_lokasi' => 'KLS02C', 'nama_lokasi' => 'Kelas 2C'],
            ['kode_lokasi' => 'KLS02D', 'nama_lokasi' => 'Kelas 2D'],
            ['kode_lokasi' => 'KLS03A', 'nama_lokasi' => 'Kelas 3A'],
            ['kode_lokasi' => 'KLS03B', 'nama_lokasi' => 'Kelas 3B'],
            ['kode_lokasi' => 'KLS03C', 'nama_lokasi' => 'Kelas 3C'],
            ['kode_lokasi' => 'KLS04A', 'nama_lokasi' => 'Kelas 4A'],
            ['kode_lokasi' => 'KLS04B', 'nama_lokasi' => 'Kelas 4B'],
            ['kode_lokasi' => 'KLS04C', 'nama_lokasi' => 'Kelas 4C'],
            ['kode_lokasi' => 'KLS05A', 'nama_lokasi' => 'Kelas 5A'],
            ['kode_lokasi' => 'KLS05B', 'nama_lokasi' => 'Kelas 5B'],
            ['kode_lokasi' => 'KLS05C', 'nama_lokasi' => 'Kelas 5C'],
            ['kode_lokasi' => 'KLS05D', 'nama_lokasi' => 'Kelas 5D'],
            ['kode_lokasi' => 'KLS06A', 'nama_lokasi' => 'Kelas 6A'],
            ['kode_lokasi' => 'KLS06B', 'nama_lokasi' => 'Kelas 6B'],
            ['kode_lokasi' => 'KLS06C', 'nama_lokasi' => 'Kelas 6C'],
            ['kode_lokasi' => 'KLS06D', 'nama_lokasi' => 'Kelas 6D'],
            ['kode_lokasi' => 'GD01', 'nama_lokasi' => 'Gudang Utama'],
            ['kode_lokasi' => 'LAB01', 'nama_lokasi' => 'Laboratorium Komputer']
        ]);
    }
}