<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangMasukController extends Controller
{
    public function create(){
        $barang = Barang::getOrderedList();
        $lokasi = Lokasi::all();
        return view('admin.barang_masuk.create', compact('barang', 'lokasi'));
    }
    public function cariBarcode($barcode){
    $barang = Barang::where('barcode', $barcode)->first();

    if (!$barang) {
        return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => [
            'id_barang' => $barang->id_barang,
            'nama_barang' => $barang->nama_barang,
            'kode_barang' => $barang->kode_barang,
            'id_kategori_barang' => $barang->id_kategori_barang
        ]
    ]);
    }

    public function store(Request $request){
       
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'sumber_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'lokasi' => 'required|exists:lokasi,id_lokasi',
            'tanggal_masuk' => 'required|date',
        ]);
        $barang = Barang::findOrFail($request->id_barang);

        BarangMasuk::create([
            'id_barang' => $barang->id_barang,
            'kode_barang' => $barang->kode_barang,
            'id_kategori_barang' => $barang->id_kategori_barang,
            'sumber_barang' => $request->sumber_barang,
            'jumlah_masuk' => $request->jumlah_masuk,
            'kondisi' => $request->kondisi,
            'id_lokasi' => $request->lokasi,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }
    public function index(Request $request)
    {
        $query = BarangMasuk::with(['kategori', 'lokasi', 'barang']);

        // Filter berdasarkan lokasi
        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }
        // Filter pencarian berdasarkan nama barang atau sumber barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('sumber_barang', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tahun masuk
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }
        // Filter berdasarkan bulan masuk
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }
        // Pagination untuk hasil query
        $barangMasuk = $query->paginate(PHP_INT_MAX);
        // Ambil data lokasi untuk dropdown
        $lokasi = Lokasi::all();

        // Return view dan kirim data barang masuk ke view
        return view('admin.barang_masuk.index', compact('barangMasuk', 'lokasi'));
    }
    public function edit($id)
    {
        $barang = BarangMasuk::findOrFail($id); // disesuaikan agar nama variabel cocok dengan blade
        $barangList = Barang::getOrderedList(); // digunakan jika nanti ingin dropdown untuk id_barang
        $lokasi = Lokasi::all();
        $kategori_barang = KategoriBarang::all(); // untuk isi dropdown kategori_barang

        return view('admin.barang_masuk.edit', compact('barang', 'barangList', 'lokasi', 'kategori_barang'));
    }



    // Mengupdate data barang masuk
 public function update(Request $request, $id)
{
    $request->validate([
        'sumber_barang' => 'required|string|max:255',
        'jumlah_masuk' => 'required|integer|min:1',
        'kondisi' => 'required|string',
        'lokasi' => 'required|exists:lokasi,id_lokasi',
        'tanggal_masuk' => 'required|date',
    ]);

    $barang = BarangMasuk::findOrFail($id);

    // Hitung stok saat ini berdasarkan kode barang
    $stokSaatIni = BarangMasuk::where('id_barang', $barang->id_barang)->sum('jumlah_masuk') -
                   BarangKeluar::where('id_barang', $barang->id_barang)->sum('jumlah_keluar');

    // Hitung stok jika jumlah masuk diubah
    $stokSetelahPerubahan = $stokSaatIni - $barang->jumlah_masuk + $request->jumlah_masuk;

    if ($stokSetelahPerubahan < 0) {
        return redirect()->back()->withErrors('Perubahan ini menyebabkan stok menjadi negatif.');
    }

    // Update data barang masuk (hanya yang bisa diedit)
    $barang->update([
        'sumber_barang' => $request->sumber_barang,
        'jumlah_masuk' => $request->jumlah_masuk,
        'kondisi' => $request->kondisi,
        'id_lokasi' => $request->lokasi,
        'tanggal_masuk' => $request->tanggal_masuk,
    ]);

    return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil diperbarui.');
}

    // Menghapus barang masuk
        public function destroy($id)
    {
        $barang = BarangMasuk::findOrFail($id);
        // Hitung stok dl sebelum di hapus
        $stokTerkini = BarangMasuk::where('id_kategori_barang', $barang->id_kategori_barang)
            ->where('nama_barang', $barang->nama_barang)
            ->sum('jumlah_masuk')
            - BarangKeluar::where('id_kategori_barang', $barang->id_kategori_barang)
            ->where('nama_barang', $barang->nama_barang)
            ->sum('jumlah_keluar');

        if ($stokTerkini - $barang->jumlah_masuk < 0) {
            return redirect()->back()->withErrors('Tidak dapat menghapus barang karena stok akan menjadi negatif.');
        }
        $barang->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        // Ambil data berdasarkan filter
        $query = BarangMasuk::with(['kategori', 'lokasi']);

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
            // ->orWhereYear('tanggal_exp', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
            // ->orWhereMonth('tanggal_exp', $request->bulan);
        }

        // Ambil data barang keluar sesuai filter
        $barangMasuk = $query->get();


        // Render view sebagai HTML
        $pdf = Pdf::loadView('admin.barang_masuk.pdf', ['barangMasuk' => $barangMasuk,]);

        // Unduh file PDF
        return $pdf->stream('daftar-barang-masuk.pdf');
    }
}