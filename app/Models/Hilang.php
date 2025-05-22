<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hilang extends Model
{
    use HasFactory;

    protected $table = 'hilangs'; // nama tabel di database
    protected $primaryKey = 'id_hilang'; // primary key-nya

    protected $fillable = [
        'id_barang_keluar',
        'jumlah_hilang',
        'tanggal_hilang',
        'keterangan',
    ];

    // Relasi ke barang_keluar
    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'id_barang_keluar');
    }
}