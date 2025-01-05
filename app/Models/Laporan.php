<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'periode_bulan',
        'periode_tahun',
        'tanggal_cetak',
        'pencetak',
        'file_laporan',
        'keterangan'
    ];
}