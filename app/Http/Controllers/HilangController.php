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
    // Tampilkan form input hilang
    public function create()
    {
        $kategori = KategoriBarang::all();
        $barangKeluar = BarangKeluar::with(['kategori', 'lokasi', 'barang', 'hilang'])
        ->where('kondisi', '!=', 'hilang')
        ->get(); // Tidak filter kondisi

        return view('admin.hilang.create', compact('barangKeluar', 'kategori'));
    }

    // Simpan data hilang
    public function store(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'id_barang_keluar' => 'required|exists:barang_keluar,id_barang_keluar',
        'jumlah_hilang' => 'required|integer|min:1',
        'tanggal_hilang' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    // Ambil data barang keluar
    $barangKeluar = BarangKeluar::with('hilang')->findOrFail($request->id_barang_keluar);

    // Hitung total hilang manual (dari tabel hilang)
    $totalHilangManual = $barangKeluar->hilang->sum('jumlah_hilang');

    // Hitung total hilang otomatis (jika kondisi = HILANG)
    $totalHilangOtomatis = $barangKeluar->kondisi === 'HILANG' ? $barangKeluar->jumlah_keluar : 0;

    // Hitung jumlah tersisa
    $jumlahTersisa = $barangKeluar->jumlah_keluar - $totalHilangManual - $totalHilangOtomatis;

    // Validasi apakah masih bisa diinput
    if ($jumlahTersisa <= 0) {
        return back()->with('error', 'Barang ini sudah tidak bisa dilaporkan hilang. Jumlahnya sudah habis.')->withInput();
    }

    // Validasi apakah jumlah yang diinput melebihi sisa
    if ($request->jumlah_hilang > $jumlahTersisa) {
        return back()->with('error', 'Jumlah hilang melebihi sisa barang. Maksimal yang dapat diinput: ' . $jumlahTersisa)->withInput();
    }

    // Simpan data ke tabel hilang
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
    // Ambil data hilang manual
    $queryManual = Hilang::with([
        'barangKeluar.kategori',
        'barangKeluar.lokasi',
        'barangKeluar.barang'
    ]);

    if ($request->filled('lokasi')) {
        $queryManual->whereHas('barangKeluar', function ($q) use ($request) {
            $q->where('id_lokasi', $request->lokasi);
        });
    }

    if ($request->filled('tahun')) {
        $queryManual->whereYear('tanggal_hilang', $request->tahun);
    }

    if ($request->filled('bulan')) {
        $queryManual->whereMonth('tanggal_hilang', $request->bulan);
    }

    $hilangManual = $queryManual->get();
    $hilangManual->each(function ($item) {
        $item->tipe = 'manual';
    });

    // Ambil data barang keluar dengan kondisi HILANG (otomatis)
    $hilangOtomatis = BarangKeluar::with(['kategori', 'lokasi', 'barang'])
        ->where('kondisi', 'HILANG');

    if ($request->filled('lokasi')) {
        $hilangOtomatis->where('id_lokasi', $request->lokasi);
    }

    if ($request->filled('tahun')) {
        $hilangOtomatis->whereYear('tanggal_keluar', $request->tahun);
    }

    if ($request->filled('bulan')) {
        $hilangOtomatis->whereMonth('tanggal_keluar', $request->bulan);
    }

    $hilangOtomatis = $hilangOtomatis->get();

    // Ubah data otomatis agar sesuai dengan struktur Hilang (pakai collection manual)
    $hilangOtomatisCollection = $hilangOtomatis->map(function ($item) {
        return (object)[
            'tipe' => 'otomatis',
            'barangKeluar' => $item,
            'jumlah_hilang' => $item->jumlah_keluar,
            'tanggal_hilang' => $item->tanggal_keluar,
            'keterangan' => 'Hilang di lokasi penyimpanan',
        ];
    });

    // Gabungkan manual dan otomatis
   $hilang = $hilangManual->concat($hilangOtomatisCollection)
    ->sortBy('tanggal_hilang')
    ->values(); // reset index biar tidak loncat


    $lokasi = Lokasi::all();

    return view('admin.hilang.index', compact('hilang', 'lokasi'));
}

public function edit($id)
{
    $hilang = Hilang::with(['barangKeluar.kategori', 'barangKeluar.lokasi', 'barangKeluar.barang'])->findOrFail($id);

    return view('admin.hilang.edit', compact('hilang'));
}
public function update(Request $request, Hilang $hilang)
{
    $request->validate([
        'jumlah_hilang' => 'required|integer|min:1',
        'tanggal_hilang' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    $barangKeluar = $hilang->barangKeluar;
    $totalHilangLain = $barangKeluar->hilang->where('id', '!=', $hilang->id)->sum('jumlah_hilang');
    $totalHilangOtomatis = $barangKeluar->kondisi === 'HILANG' ? $barangKeluar->jumlah_keluar : 0;

    $jumlahTersisa = $barangKeluar->jumlah_keluar - $totalHilangLain - $totalHilangOtomatis;

    if ($request->jumlah_hilang > $jumlahTersisa) {
        return back()->with('error', 'Jumlah hilang melebihi sisa barang. Maksimal: ' . $jumlahTersisa)->withInput();
    }

    $hilang->update([
        'jumlah_hilang' => $request->jumlah_hilang,
        'tanggal_hilang' => $request->tanggal_hilang,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('hilang.index')->with('success', 'Data barang hilang berhasil diperbarui.');
}

public function destroy($id)
{
    $hilang = Hilang::findOrFail($id);
    $hilang->delete();

    return redirect()->route('hilang.index')->with('success', 'Data barang hilang berhasil dihapus.');
}
    public function exportPdf(Request $request)
{
    // Ambil data hilang manual (dari tabel Hilang)
    $queryManual = Hilang::with([
        'barangKeluar.kategori',
        'barangKeluar.lokasi',
        'barangKeluar.barang'
    ]);

    if ($request->filled('lokasi')) {
        $queryManual->whereHas('barangKeluar', function ($q) use ($request) {
            $q->where('id_lokasi', $request->lokasi);
        });
    }

    if ($request->filled('tahun')) {
        $queryManual->whereYear('tanggal_hilang', $request->tahun);
    }

    if ($request->filled('bulan')) {
        $queryManual->whereMonth('tanggal_hilang', $request->bulan);
    }

    $hilangManual = $queryManual->get();
    $hilangManual->each(function ($item) {
        $item->tipe = 'manual';
    });

    // Ambil data barang keluar dengan kondisi HILANG (otomatis)
    $hilangOtomatis = BarangKeluar::with(['kategori', 'lokasi', 'barang'])
        ->where('kondisi', 'HILANG');

    if ($request->filled('lokasi')) {
        $hilangOtomatis->where('id_lokasi', $request->lokasi);
    }

    if ($request->filled('tahun')) {
        $hilangOtomatis->whereYear('tanggal_keluar', $request->tahun);
    }

    if ($request->filled('bulan')) {
        $hilangOtomatis->whereMonth('tanggal_keluar', $request->bulan);
    }

    $hilangOtomatis = $hilangOtomatis->get();

    // Format otomatis agar seragam dengan manual
    $hilangOtomatisCollection = $hilangOtomatis->map(function ($item) {
        return (object)[
            'tipe' => 'otomatis',
            'barangKeluar' => $item,
            'jumlah_hilang' => $item->jumlah_keluar,
            'tanggal_hilang' => $item->tanggal_keluar,
            'keterangan' => 'Hilang di lokasi penyimpanan',
        ];
    });

    // Gabungkan semua data
   $hilang = $hilangManual->concat($hilangOtomatisCollection)
    ->sortBy('tanggal_hilang')
    ->values(); // reset index biar tidak loncat


    // Kirim ke PDF view
    $pdf = Pdf::loadView('admin.hilang.pdf', [
        'hilang' => $hilang
    ]);

    return $pdf->stream('barang-hilang.pdf');
}

}