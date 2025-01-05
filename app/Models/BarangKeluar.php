<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id_barang_keluar';

    protected $fillable = [
        'id_kategori_barang',
        'nama_barang',
        'jumlah_keluar',
        'kondisi',
        'id_lokasi',
        'tanggal_keluar',
        'masa_pakai',
        'tanggal_exp',
        'nama_penanggungjawab'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori_barang', 'id_kategori_barang');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class,  'id_lokasi', 'id_lokasi');
    }
}