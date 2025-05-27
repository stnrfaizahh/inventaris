<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $barang = Barang::findOrFail($id);
        return Pdf::loadView('admin.barang.qrcode', compact('barang'))
            ->setPaper('A4', 'portrait')
            ->stream('label-barang-' . $barang->kode_barang . '.pdf');
    }

    // Form for cetak satu barang
    public function formCetakSatu($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.cetak_satu_form', compact('barang'));
    }

    // Cetak satu barang
    public function cetakSatu(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1'
        ]);

        $barang = Barang::findOrFail($request->id_barang);
        $jumlah = $request->jumlah;

        $barangList = collect();
        for ($i = 0; $i < $jumlah; $i++) {
            $barangList->push($barang);
        }

        $pdf = PDF::loadView('admin.barang.qrcode', compact('barangList'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('barcode-' . $barang->kode_barang . '.pdf');
    }
}