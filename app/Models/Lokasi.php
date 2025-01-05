<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_lokasi', 'id_lokasi');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_lokasi', 'id_lokasi');
    }
}