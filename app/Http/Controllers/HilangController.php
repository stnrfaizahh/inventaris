<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;

class HilangController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['kategori', 'lokasi'])->where('kondisi', 'hilang');

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $request->bulan);
        }

        $barangKeluar = $query->paginate(PHP_INT_MAX);
        $lokasi = Lokasi::all();

        return view('admin.hilang.index', compact('barangKeluar', 'lokasi'));
    }

    public function exportPdf(Request $request)
    {
        $query = BarangKeluar::with(['kategori', 'lokasi'])->where('kondisi', 'hilang');

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $request->bulan);
        }

        $barangKeluar = $query->get();

        $pdf = Pdf::loadView('admin.hilang.pdf', ['barangKeluar' => $barangKeluar]);

        return $pdf->stream('barang-hilang.pdf');
    }
}
