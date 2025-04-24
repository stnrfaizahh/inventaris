<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\HilangController;
use App\Models\KategoriBarang;
use Illuminate\Routing\Router;

Route::get('/', function () {
    return view('welcome');
});
 

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');


Route::middleware('auth')->group(function () {
    Route::resource('barang-masuk', BarangMasukController::class)->except(['show']);
    Route::resource('barang-keluar', BarangKeluarController::class)->except(['show']);
    Route::get('/barang-masuk/export-pdf', [BarangMasukController::class, 'exportPdf'])->name('barang-masuk.export-pdf');
    Route::get('/barang-keluar/export-pdf', [BarangKeluarController::class, 'exportPdf'])->name('barang-keluar.export-pdf');
    
    Route::resource('hilang', HilangController::class)->except(['show']); 
    Route::get('/hilang/export-pdf', [HilangController::class, 'exportPdf'])->name('hilang.export-pdf');

    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);


    // Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';