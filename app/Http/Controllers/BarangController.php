<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    // Tampilkan semua barang
    public function index()
    {
        $barang = Barang::getOrderedList();
        return view('admin.barang.index', compact('barang'));
    }

    // Tampilkan form tambah barang
    public function create()
    {
        $kategori = KategoriBarang::all();
        return view('admin.barang.create', compact('kategori'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|string|max:255',
        ]);
        $kategori = KategoriBarang::findOrFail($request->id_kategori_barang);
        $kodeKategori = strtoupper($kategori->kode_kategori);
        $jumlahBarang = Barang::where('id_kategori_barang', $kategori->id_kategori_barang)->count();
        $nomorUrut = str_pad($jumlahBarang + 1, 3, '0', STR_PAD_LEFT);
        $kodeBarang = $kodeKategori . $nomorUrut;

       
        $barcode = 'BRG-' . strtoupper(Str::random(8));

        Barang::create([
            'id_kategori_barang' => $request->id_kategori_barang,
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $kodeBarang,
            'barcode' => $barcode,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Tampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = KategoriBarang::all();

        $adaTransaksi = $barang->barangMasuk()->exists() || $barang->barangKeluar()->exists();

        return view('admin.barang.edit', compact('barang', 'kategori', 'adaTransaksi'));
    }


    // Update barang
    public function update(Request $request, Barang $barang)
{
    $adaTransaksi = $barang->barangMasuk()->exists() || $barang->barangKeluar()->exists();

    $rules = [
        'nama_barang' => 'required|string|max:255',
    ];

    if (!$adaTransaksi) {
        $rules['id_kategori_barang'] = 'required|exists:kategori_barang,id_kategori_barang';
    }

    $validated = $request->validate($rules);

    if (!$adaTransaksi) {
        $barang->id_kategori_barang = $validated['id_kategori_barang'];
    }

    $barang->nama_barang = $validated['nama_barang'];
    $barang->save();

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}


    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
         if (
        $barang->barangMasuk()->exists() ||
        $barang->barangKeluar()->exists()
        // tambahkan validasi ini jika sudah ada relasi barang hilang:
        // || $barang->barangHilang()->exists()
    ) {
        return redirect()->route('barang.index')->with('error', 'Barang ini tidak dapat dihapus karena sudah digunakan dalam transaksi.');
    }
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    // Print QR Code to PDF
   public function printQr($id)
{
    $barang = Barang::with(['kategori'])->findOrFail($id);

    $qrData = [
        'Kode' => $barang->kode_barang,
        'Nama Barang' => $barang->nama_barang,
        'Kategori' => $barang->kategori->nama_kategori_barang ?? '-',
    ];

    $qrContent = json_encode($qrData);

    $items = collect([$barang]); // Agar bisa pakai foreach jika layout sama
    return view('admin.barang.qrcode', compact('items', 'qrContent'));
}

public function info($kodeBarang)
{
    $barang = Barang::with('kategori')->where('kode_barang', $kodeBarang)->first();

    if ($barang) {
        $jumlahMasuk = $barang->barangMasuk()->sum('jumlah_masuk');
        $jumlahKeluar = $barang->barangKeluar()->sum('jumlah_keluar');
        $stok = $jumlahMasuk - $jumlahKeluar;

        return response()->json([
            'success' => true,
            'nama_barang' => $barang->nama_barang,
            'kategori' => $barang->kategori->nama_kategori_barang ?? '-',
            'stok' => $stok
        ]);
    }

    return response()->json(['success' => false], 404);
}

}