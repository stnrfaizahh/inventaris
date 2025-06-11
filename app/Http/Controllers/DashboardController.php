<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $totalBarangMasuk = BarangMasuk::sum('jumlah_masuk');
        $totalBarangKeluar = BarangKeluar::sum('jumlah_keluar');
        $jumlahKategori = KategoriBarang::count();
        $jumlahLokasi = Lokasi::count();

        $jumlahPerKondisi = BarangMasuk::select('kondisi')
            ->selectRaw('SUM(jumlah_masuk) as total')
            ->groupBy('kondisi')
            ->get()
            ->pluck('total', 'kondisi');

        // Ambil data barang masuk, dan kelompokkan berdasarkan kategori dan nama barang
       $barangMasuk = BarangMasuk::with('barang')
        ->select('id_kategori_barang', 'id_barang')
        ->selectRaw('SUM(jumlah_masuk) as jumlah_masuk')
        ->when($search, function ($query, $search) {
            return $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%");
            });
        })
        ->groupBy('id_kategori_barang', 'id_barang')
        ->get();


        // Ambil data barang keluar, dan kelompokkan berdasarkan kategori dan nama barang
        $barangKeluar = BarangKeluar::with('barang') // tambahkan ini
            ->select('id_kategori_barang', 'id_barang')
            ->selectRaw('SUM(jumlah_keluar) as jumlah_keluar')
            ->when($search, function ($query, $search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->groupBy('id_kategori_barang', 'id_barang')
            ->get();


        // Gabungkan data barang masuk dan barang keluar
       $stokBarang = $barangMasuk->map(function ($barang) use ($barangKeluar) {
            $keluar = $barangKeluar->where('id_kategori_barang', $barang->id_kategori_barang)
                ->where('id_barang', $barang->id_barang)
                ->first();

            $barang->jumlah_keluar = $keluar ? $keluar->jumlah_keluar : 0;
            $barang->stok = $barang->jumlah_masuk - $barang->jumlah_keluar;

            return $barang;
        });


        $stokBarang = $stokBarang->sortBy(function ($barang) {
            return optional($barang->barang->kategori)->nama_kategori_barang;
        });


        return view('dashboard', compact(
            'stokBarang',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'jumlahKategori',
            'jumlahLokasi',
            'jumlahPerKondisi',
            'search'

        ));
    }
    public function getChartData()
{
    $data = BarangMasuk::selectRaw('MONTH(tanggal_masuk) as month, SUM(jumlah_masuk) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Format data untuk frontend
    $formattedData = [
        'months' => $data->pluck('month')->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->format('M');
        }),
        'totals' => $data->pluck('total'),
    ];

    return response()->json($formattedData);
}

    
}