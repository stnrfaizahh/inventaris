<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_lokasi' => 'required|unique:lokasi,kode_lokasi',
            'nama_lokasi' => 'required',
        ]);

        Lokasi::create($request->all());
        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        if ($lokasi->barangMasuk()->exists() || $lokasi->barangKeluar()->exists()) {
            return redirect()->route('lokasi.index')->with('error', 'Lokasi ini tidak dapat diedit karena sudah digunakan dalam transaksi.');
        }
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_lokasi' => 'required|unique:lokasi,kode_lokasi,'.$id.',id_lokasi',
            'nama_lokasi' => 'required',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        if ($lokasi->barangMasuk()->exists() || $lokasi->barangKeluar()->exists()) {
            return redirect()->route('lokasi.index')->with('error', 'Lokasi ini tidak dapat diedit karena sudah digunakan dalam transaksi.');
        }
        $lokasi->update($request->all());
        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        if ($lokasi->barangMasuk()->exists() || $lokasi->barangKeluar()->exists()) {
            return redirect()->route('lokasi.index')->with('error', 'Lokasi ini tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }
        $lokasi->delete();
        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}