<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;

class BarangKeluarController extends Controller
{
    public function create()
    {
    
       $barangMasuk = Barang::with('kategori')
            ->get()
            ->sortBy('kode_barang')
            ->groupBy(fn($item) => $item->kategori->nama_kategori_barang);
        $lokasi = Lokasi::all();
        
        return view('admin.barang_keluar.create', compact('barangMasuk', 'lokasi'));
    }

    public function cariBarcode($kode)
    {
        $barang = Barang::where('kode_barang', $kode)->first();

        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id_barang' => $barang->id,
                    'nama_barang' => $barang->nama,
                    'kategori' => $barang->kategori->nama,
                    'stok' => $barang->stok
                ]
            ]);
        }

        return response()->json(['status' => 'error']);
    }


    // Menyimpan data barang keluar
    public function store(Request $request)
{
    $request->validate([
        'id_barang' => 'required|exists:barang,id_barang',
        'jumlah_keluar' => 'required|integer|min:1',
        'kondisi' => 'required',
        'lokasi' => 'required|exists:lokasi,id_lokasi',
        'tanggal_keluar' => 'required|date',
        'masa_pakai' => 'required|integer|min:1',
        'nama_penanggungjawab' => 'required|string',
    ]);

    // Ambil data barang berdasarkan id_barang
    $barang = Barang::with('kategori')->find($request->id_barang);
    if (!$barang) {
        return redirect()->back()->with('error', 'Barang tidak ditemukan.')->withInput();
    }

    // Hitung total stok
    $totalStok = BarangMasuk::where('id_barang', $barang->id_barang)->sum('jumlah_masuk')
                - BarangKeluar::where('id_barang', $barang->id_barang)->sum('jumlah_keluar');

    if ($totalStok < $request->jumlah_keluar) {
        return redirect()->back()->with('error', 'Jumlah barang keluar melebihi stok yang tersedia.')->withInput();
    }

    $tanggalExp = Carbon::parse($request->tanggal_keluar)->addMonths((int)$request->masa_pakai);

    // Ambil kode barang dari barang masuk (assumsi: data konsisten)
    $barangMasuk = BarangMasuk::where('id_barang', $barang->id_barang)->first();
    $kodeBarangMasuk = $barangMasuk->kode_barang ?? 'UNKNOWN';
    
   // Buat prefix awal dari kode barang dan lokasi
    $prefix = $kodeBarangMasuk . '-' . $request->lokasi;
    // Hitung jumlah record yang sudah memakai prefix tersebut
    $count = BarangKeluar::where('kode_barang_keluar', 'like', "$prefix%")->count() + 1;
    // Format kode unik dengan urutan
    $kodeBarangKeluar = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

    // Simpan data
    BarangKeluar::create([
        'id_barang' => $barang->id_barang,
        'id_kategori_barang' => $barang->id_kategori_barang,
        'jumlah_keluar' => $request->jumlah_keluar,
        'kondisi' => $request->kondisi,
        'id_lokasi' => $request->lokasi,
        'tanggal_keluar' => $request->tanggal_keluar,
        'masa_pakai' => $request->masa_pakai,
        'tanggal_exp' => $tanggalExp,
        'nama_penanggungjawab' => $request->nama_penanggungjawab,
        'kode_barang_keluar' => $kodeBarangKeluar,
    ]);

    return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil ditambahkan');
}

    public function index(Request $request)
    {
        $query = BarangKeluar::with(['kategori', 'lokasi', 'barang']);

        // Filter berdasarkan lokasi
        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }
        // Filter pencarian berdasarkan nama barang atau kategori barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori_barang', 'like', "%{$search}%");
                    });
            });
        }
        
        // Filter berdasarkan tahun keluar/expired
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $request->tahun);
            // ->orWhereYear('tanggal_exp', $request->tahun);
        }
        // Filter berdasarkan bulan keluar/expired
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $request->bulan);
            // ->orWhereMonth('tanggal_exp', $request->bulan);
        }

        // Pagination untuk hasil query
        $barangKeluar = $query->paginate(PHP_INT_MAX);
        // Ambil data lokasi untuk dropdown
        $lokasi = Lokasi::all();

        return view('admin.barang_keluar.index', compact('barangKeluar', 'lokasi'));
    }


    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $kategori_barang = KategoriBarang::all();
        $lokasi = Lokasi::all();

        return view('admin.barang_keluar.edit', compact('barangKeluar', 'kategori_barang', 'lokasi'));
    }

    // Mengupdate data barang keluar
 public function update(Request $request, $id)
{
    $request->validate([
        'jumlah_keluar' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
        'masa_pakai' => 'required|integer|min:1',
        'kondisi' => 'required|string',
        'lokasi' => 'required|exists:lokasi,id_lokasi',
        'nama_penanggungjawab' => 'required|string',
    ]);

    $barangKeluar = BarangKeluar::findOrFail($id);

   // Hitung stok berdasarkan semua barang masuk dan keluar (kecuali record yang sedang diedit)
    $jumlahMasuk = BarangMasuk::where('id_barang', $barangKeluar->id_barang)->sum('jumlah_masuk');
    $jumlahKeluar = BarangKeluar::where('id_barang', $barangKeluar->id_barang)
                                ->where('id_barang_keluar', '!=', $id)
                                ->sum('jumlah_keluar');
    $stokTersedia = $jumlahMasuk - $jumlahKeluar;

    if ($request->jumlah_keluar > $stokTersedia) {
        return redirect()->back()->withErrors(['jumlah_keluar' => 'Jumlah keluar melebihi stok tersedia (' . $stokTersedia . ').'])->withInput();
    }

    $tanggalExp = Carbon::parse($request->tanggal_keluar)->addMonths((int)$request->masa_pakai);

    $barangKeluar->update([
        'jumlah_keluar' => $request->jumlah_keluar,
        'kondisi' => $request->kondisi,
        'id_lokasi' => $request->lokasi,
        'tanggal_keluar' => $request->tanggal_keluar,
        'masa_pakai' => $request->masa_pakai,
        'nama_penanggungjawab' => $request->nama_penanggungjawab,
        'tanggal_exp' => $tanggalExp,
    ]);

    return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil diperbarui.');
}
    public function destroy($id)
    {
        $barang = BarangKeluar::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dihapus.');
    }

    public function getNamaBarangKeluar(Request $request)
    {
        // Ambil nama barang unik berdasarkan kategori barang
        $namaBarang = BarangMasuk::where('id_kategori_barang', $request->kategori_id)
            ->select('nama_barang') // Pilih kolom nama_barang saja
            ->distinct() // Hilangkan duplikasi
            ->get();

        return response()->json($namaBarang);
    }

    public function exportPdf(Request $request)
    {
        // Ambil data berdasarkan filter
        $query = BarangKeluar::with(['kategori', 'lokasi']);

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $request->tahun);
            // ->orWhereYear('tanggal_exp', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $request->bulan);
            // ->orWhereMonth('tanggal_exp', $request->bulan);
        }

        // Ambil data barang keluar sesuai filter
        $barangKeluar = $query->get();


        // Render view sebagai HTML
        $pdf = Pdf::loadView('admin.barang_keluar.pdf', ['barangKeluar' => $barangKeluar,]);

        // Unduh file PDF
        return $pdf->stream('daftar-barang-keluar.pdf');
    }
    public function printQr($id)
    {
        $barangKeluar = BarangKeluar::with(['kategori', 'lokasi'])->findOrFail($id);

        // Buat isi QR code dengan info penting
        $qrData = [
            'Kode' => $barangKeluar->kode_barang_keluar,
            'Nama Barang' => $barangKeluar->nama_barang,
            'Lokasi' => $barangKeluar->lokasi->nama_lokasi,
            'Tanggal Keluar' => Carbon::parse($barangKeluar->tanggal_keluar)->format('Y-m-d'),
            'Tanggal Expired' =>  Carbon::parse($barangKeluar->tanggal_exp)->format('Y-m-d'),
        ];

        $qrContent = json_encode($qrData); // atau format teks biasa
        $items = collect([$barangKeluar]);
        return view('admin.barang_keluar.qrcode', compact('items'));
    }
    public function printQrAll(Request $request)
    {
    $query = BarangKeluar::with(['kategori', 'lokasi']);

    // Terapkan filter lokasi jika ada
    if ($request->filled('lokasi')) {
        $query->where('id_lokasi', $request->lokasi);
    }

    // Terapkan filter tahun
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_keluar', $request->tahun);
    }

    // Terapkan filter bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_keluar', $request->bulan);
    }

    $items = $query->get();

    return view('admin.barang_keluar.qrcode', compact('items'));
    }

}