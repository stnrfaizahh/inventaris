<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Hilang;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarisController extends Controller
{
    
    public function index(Request $request)
    {
        $lokasiId = $request->lokasi;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $search = $request->search;
        $lokasiList = Lokasi::all();
        $kategoriList = KategoriBarang::all();

        // Ambil semua barang master
        $barangList = Barang::with('kategori')
            ->when($search, function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori_barang', 'like', "%{$search}%"));
            })
            ->get();

        $data = [];

        foreach ($barangList as $barang) {
            // Cek semua lokasi (atau lokasi filter)
            $lokasiTarget = $lokasiId ? Lokasi::where('id_lokasi', $lokasiId)->get() : $lokasiList;

            foreach ($lokasiTarget as $lokasi) {
                // Total barang keluar ke lokasi ini
                $keluar = BarangKeluar::where('id_barang', $barang->id_barang)
                    ->where('id_lokasi', $lokasi->id_lokasi)
                    ->when($tahun, fn($q) => $q->whereYear('tanggal_keluar', $tahun))
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal_keluar', $bulan))
                    ->sum('jumlah_keluar');
                    
                // Hilang otomatis
                $hilangOt = BarangKeluar::where('id_barang', $barang->id_barang)
                    ->where('id_lokasi', $lokasi->id_lokasi)
                    ->where('kondisi', 'HILANG')
                    ->when($tahun, fn($q) => $q->whereYear('tanggal_keluar', $tahun))
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal_keluar', $bulan))
                    ->sum('jumlah_keluar');

                // Hilang manual
                $hilangManual = Hilang::whereHas('barangKeluar', function ($q) use ($barang, $lokasi, $tahun, $bulan) {
                    $q->where('id_barang', $barang->id_barang)
                    ->where('id_lokasi', $lokasi->id_lokasi)
                    ->when($tahun, fn($q) => $q->whereYear('tanggal_keluar', $tahun))
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal_keluar', $bulan));
                            })->sum('jumlah_hilang');

                $jumlah = $keluar - $hilangOt - $hilangManual;

                if ($jumlah > 0) {
                    $penanggungJawab = BarangKeluar::where('id_barang', $barang->id_barang)
                        ->where('id_lokasi', $lokasi->id_lokasi)
                        ->latest('tanggal_keluar')
                        ->first()?->nama_penanggungjawab ?? '-';

                    $data[] = [
                        'kategori' => $barang->kategori->nama_kategori_barang,
                        'nama_barang' => $barang->nama_barang,
                        'jumlah' => $jumlah,
                        'lokasi' => $lokasi->nama_lokasi,
                        'penanggung_jawab' => $penanggungJawab,
                    ];
                }
            }
        }
        return view('admin.inventaris.index', compact('data', 'lokasiList', 'kategoriList', 'lokasiId', 'search', 'tahun', 'bulan'));
    }
    public function exportPdf(Request $request)
{
    $lokasiId = $request->lokasi;
    $kategoriId = $request->kategori;


    $lokasiList = Lokasi::all();
    $kategoriList = KategoriBarang::all();
    $barangList = Barang::with('kategori')
        ->when($kategoriId, fn($q) => $q->where('id_kategori_barang', $kategoriId))
        ->get();
    $data = [];

    foreach ($barangList as $barang) {
        $lokasiTarget = $lokasiId ? Lokasi::where('id_lokasi', $lokasiId)->get() : $lokasiList;

        foreach ($lokasiTarget as $lokasi) {
            $keluar = BarangKeluar::where('id_barang', $barang->id_barang)
                ->where('id_lokasi', $lokasi->id_lokasi)
                ->sum('jumlah_keluar');

            $hilangOt = BarangKeluar::where('id_barang', $barang->id_barang)
                ->where('id_lokasi', $lokasi->id_lokasi)
                ->where('kondisi', 'HILANG')
                ->sum('jumlah_keluar');

            $hilangManual = Hilang::whereHas('barangKeluar', function ($q) use ($barang, $lokasi) {
                $q->where('id_barang', $barang->id_barang)
                ->where('id_lokasi', $lokasi->id_lokasi);
            })->sum('jumlah_hilang');

            $jumlah = $keluar - $hilangOt - $hilangManual;

            if ($jumlah > 0) {
                $penanggungJawab = BarangKeluar::where('id_barang', $barang->id_barang)
                    ->where('id_lokasi', $lokasi->id_lokasi)
                    ->latest('tanggal_keluar')
                    ->first()?->nama_penanggungjawab ?? '-';

                $data[] = [
                    'kategori' => $barang->kategori->nama_kategori_barang,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah' => $jumlah,
                    'lokasi' => $lokasi->nama_lokasi,
                    'penanggung_jawab' => $penanggungJawab,
                ];
            }
        }
    }

    $pdf = Pdf::loadView('admin.inventaris.pdf', compact('data', 'lokasiId', 'kategoriId'));
    return $pdf->stream('laporan-inventaris.pdf');
}
}