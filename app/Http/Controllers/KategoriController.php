<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use GuzzleHttp\Promise\Create;

class KategoriController extends Controller
{
    public function index(){
        $kategori = KategoriBarang::all();
        return view('admin.kategori.index', compact('kategori'));
    }
    public function create(){
        return view('admin.kategori.create'); 
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_barang,kode_kategori',
            'nama_kategori_barang' => 'required',
        ]);

        KategoriBarang::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        if ($kategori->barangMasuk()->exists() || $kategori->barangKeluar()->exists()) {
            return redirect()->route('kategori.index')->with('error', 'Kategori ini tidak dapat diedit karena sudah digunakan dalam transaksi.');
        }
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_barang,kode_kategori,'.$id.',id_kategori_barang',
            'nama_kategori_barang' => 'required',
        ]);

        $kategori = KategoriBarang::findOrFail($id);
        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        if ($kategori->barangMasuk()->exists() || $kategori->barangKeluar()->exists()) {
            return redirect()->route('kategori.index')->with('error', 'Kategori ini tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}