<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // pastikan sesuai nama tabel kamu
    protected $primaryKey = 'id_barang'; // sesuaikan dengan primary key

    protected $fillable = [
        'id_kategori_barang',
        'kode_barang',
        'nama_barang',
        'barcode',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori_barang', 'id_kategori_barang');
    }

    // Relasi ke barang masuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang');
    }

    // Relasi ke barang keluar
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang');
    }
    
    public static function getOrderedList()
    {
        return self::with('kategori')
            ->orderBy('id_kategori_barang')
            ->orderBy('kode_barang')
            ->get();
    }
}