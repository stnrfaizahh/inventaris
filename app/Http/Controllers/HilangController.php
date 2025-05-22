<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use App\Models\Hilang;
use Barryvdh\DomPDF\Facade\Pdf;

class HilangController extends Controller
{
    public function create()
{
    // Ambil semua barang keluar yang belum hilang
    $kategori = KategoriBarang::all(); // untuk dropdown filter
    $barangKeluar = BarangKeluar::with(['kategori', 'lokasi'])
                    ->where('kondisi', '!=', 'hilang')
                    ->get();



    return view('admin.hilang.create', compact('barangKeluar', 'kategori'));
}

public function store(Request $request)
{
    $request->validate([
        'id_barang_keluar' => 'required|exists:barang_keluar,id_barang_keluar',
        'jumlah_hilang' => 'required|integer|min:1',
        'tanggal_hilang' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    $barangKeluar = BarangKeluar::findOrFail($request->id_barang_keluar);

    // Update kondisi barang keluar menjadi "hilang"
    $barangKeluar->kondisi = 'hilang';
    $barangKeluar->save();

    // Simpan data hilang (jika tabel 'hilang' tersedia)
    Hilang::create([
        'id_barang_keluar' => $barangKeluar->id_barang_keluar,
        'jumlah_hilang' => $request->jumlah_hilang,
        'tanggal_hilang' => $request->tanggal_hilang,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('hilang.index')->with('success', 'Data barang hilang berhasil ditambahkan.');
}
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['kategori', 'lokasi', 'hilang'])->where('kondisi', 'hilang');

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