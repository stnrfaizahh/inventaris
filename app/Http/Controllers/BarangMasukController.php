<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Laporan;
use App\Models\Lokasi;


class BarangMasukController extends Controller
{
    public function create()
    {
        $kategori_barang = KategoriBarang::all();
        $lokasi = Lokasi::all();
        return view('admin.barang_masuk.create', compact('kategori_barang', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|string|max:255',
            'sumber_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'lokasi' => 'required|exists:lokasi,id_lokasi',
            'tanggal_masuk' => 'required|date',
        ]);

        // Generate kode barang masuk
        $kodeBarang = $this->generateBarangMasukId($request);

        // Buat entri baru setiap kali ada input
        BarangMasuk::create([
            'kode_barang' => $kodeBarang,
            'id_kategori_barang' => $request->kategori_barang,
            'nama_barang' => $request->nama_barang,
            'sumber_barang' => $request->sumber_barang,
            'jumlah_masuk' => $request->jumlah_masuk,
            'kondisi' => $request->kondisi,
            'id_lokasi' => $request->lokasi,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    private function generateBarangMasukId(Request $request)
    {
        // Cari apakah barang sudah pernah masuk berdasarkan kategori dan nama barang
        $existingBarangMasuk = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
            ->where('nama_barang', $request->nama_barang)
            ->first();

        if ($existingBarangMasuk) {
            // Jika barang sudah ada, gunakan kembali kode barang yang sama
            $kode_barang = $existingBarangMasuk->kode_barang;
        } else {
            // Jika barang belum ada, buat kode barang baru
            $lastBarang = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
                ->orderBy('kode_barang', 'desc')
                ->first();

            $newNumber = 1;

            if ($lastBarang) {
                // Dapatkan angka dari kode barang terakhir dan tambahkan 1
                $newNumber = intval(substr($lastBarang->kode_barang, -3)) + 1;
            }

            // Ambil kode kategori dari kategori_barang yang dipilih
            $kategori = KategoriBarang::find($request->kategori_barang);

            // Buat kode barang baru dengan format kategori + 3 digit angka
            $kode_barang = strtoupper($kategori->kode_kategori) . sprintf("%03d", $newNumber);
        }
        return $kode_barang;
    }


    public function index(Request $request)
    {
        // Ambil semua data barang masuk dari database
        $barangMasuk = BarangMasuk::with(['kategori', 'lokasi'])->get();

        $query = BarangMasuk::with(['kategori', 'lokasi']);

        // Filter pencarian berdasarkan nama barang atau sumber barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('sumber_barang', 'like', "%{$search}%");
            });
        }
    
        // Ambil data dengan filter pencarian
        $barangMasuk = $query->get();
        // Return view dan kirim data barang masuk ke view
        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }
    public function edit($id)
    {
        $barang = BarangMasuk::with('kategori', 'lokasi')->findOrFail($id);
        $kategori_barang = KategoriBarang::all();
        $lokasi = Lokasi::all();
        return view('admin.barang_masuk.edit', compact('barang', 'kategori_barang', 'lokasi'));
    }

    // Mengupdate data barang masuk
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|string|max:255',
            'sumber_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'lokasi' => 'required|exists:lokasi,id_lokasi',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang = BarangMasuk::findOrFail($id);

        // Validasi apakah perubahan kategori atau nama menyebabkan stok negatif
        if (
            $barang->id_kategori_barang != $request->kategori_barang ||
            $barang->nama_barang != $request->nama_barang
        ) {
            $stokTerkini = BarangMasuk::where('id_kategori_barang', $barang->id_kategori_barang)
                ->where('nama_barang', $barang->nama_barang)
                ->sum('jumlah_masuk')
                - BarangKeluar::where('id_kategori_barang', $barang->id_kategori_barang)
                ->where('nama_barang', $barang->nama_barang)
                ->sum('jumlah_keluar')?? 0;

            $stokSetelahPerubahan = $stokTerkini - $barang->jumlah_masuk + $request->jumlah_masuk;

            if ($stokSetelahPerubahan < 0) {
                return redirect()->back()->withErrors('Tidak dapat mengubah kategori atau nama barang karena stok akan menjadi negatif.');
            }

            // Jika kategori atau nama barang berubah, buat kode barang baru
            $kodeBarangBaru = $this->generateBarangMasukId($request);
        } else {
            // Jika tidak berubah, tetap gunakan kode barang lama
            $kodeBarangBaru = $barang->kode_barang;
        }

        // Validasi jumlah masuk untuk stok yang baru
        $stokTerkini = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
            ->where('nama_barang', $request->nama_barang)
            ->sum('jumlah_masuk')
            - BarangKeluar::where('id_kategori_barang', $request->kategori_barang)
            ->where('nama_barang', $request->nama_barang)
            ->sum('jumlah_keluar');

        if ($stokTerkini - $barang->jumlah_masuk + $request->jumlah_masuk < 0) {
            return redirect()->back()->withErrors('Tidak dapat mengubah data karena stok akan menjadi negatif.');
        }

        // Update data barang masuk
        $barang->update([
            'kode_barang' => $kodeBarangBaru,
            'id_kategori_barang' => $request->kategori_barang,
            'nama_barang' => $request->nama_barang,
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
}