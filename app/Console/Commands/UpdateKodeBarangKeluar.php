<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
class UpdateKodeBarangKeluar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:kode-barang-keluar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   public function handle()
{
    $barangKeluarAll = BarangKeluar::with('barang.barangMasuk')->get();
    $urutanMap = [];

    foreach ($barangKeluarAll as $bk) {
        $barangMasuk = $bk->barang->barangMasuk()->first();

        if (!$barangMasuk) {
            $this->error("Barang masuk tidak ditemukan untuk ID: {$bk->id_barang_keluar}");
            continue;
        }

        $kodeBarangMasuk = $barangMasuk->kode_barang;
        $lokasiId = $bk->id_lokasi;
        $key = $kodeBarangMasuk . '-' . $lokasiId;

        if (!isset($urutanMap[$key])) {
            $urutanMap[$key] = 1;
        }

        $kodeBaru = $key . '-' . str_pad($urutanMap[$key], 3, '0', STR_PAD_LEFT);
        $bk->kode_barang_keluar = $kodeBaru;
        $bk->save();

        $urutanMap[$key]++;
    }

    $this->info("✅ Semua data barang keluar berhasil diperbarui.");
}
}