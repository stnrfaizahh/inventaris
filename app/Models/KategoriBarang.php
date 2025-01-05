<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KategoriBarang extends Model
{
    use HasFactory;
    protected $table = 'kategori_barang';
    protected $primaryKey = 'id_kategori_barang';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori_barang',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_kategori_barang', 'id_kategori_barang');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_kategori_barang', 'id_kategori_barang');
    }
}