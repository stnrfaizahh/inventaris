<?php

namespace App\Http\Controllers;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class ScanBarcodeController extends Controller
{
public function index(Request $request)
{
    $barcode = $request->get('barcode');
    $barang = null;

    if ($barcode) {
        $barang = BarangKeluar::with(['barang', 'kategori', 'lokasi'])
            ->where('kode_barang_keluar', $barcode)
            ->first();
    }

    return view('admin.scan_barcode.index', compact('barang', 'barcode'));
}

public function cari(Request $request)
{
    $kode = $request->input('kode_barang_keluar');

    $barang = BarangKeluar::where('kode_barang_keluar', $kode)
        ->with(['kategori', 'barang', 'lokasi'])
        ->first();

    if ($barang) {
        return response()->json(['success' => true, 'data' => $barang]);
    } else {
        return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan.']);
    }
}

}