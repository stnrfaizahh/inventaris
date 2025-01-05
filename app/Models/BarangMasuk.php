<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang_masuk';

    protected $fillable = [
        'id_kategori_barang',
        'nama_barang',
        'kode_barang',
        'sumber_barang',
        'jumlah_masuk',
        'kondisi',
        'id_lokasi',
        'tanggal_masuk'
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