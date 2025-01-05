@extends('layouts.app')

@section('title','E-Invensi-Dashboard')
@section('header','Data Barang')
@section('content')

 <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-bi bi-box-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Barang Masuk</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalBarangMasuk }}</h6>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card"> 
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-bi bi-boxes"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Barang Keluar</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalBarangKeluar }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Kategori</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahKategori }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-bi bi-geo-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Lokasi</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahLokasi }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Barang Masuk</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-12 col-lg-3">
                <div class="card">
                        <div class="card-header">
                            <h4>Kondisi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="{{asset('dist/assets/static/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Baru</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">{{ $jumlahPerKondisi['Baru'] ?? 0 }}</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-europe"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue"style="width:10px">
                                            <use
                                                xlink:href="{{asset('dist/assets/static/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Diperbaiki</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">{{ $jumlahPerKondisi['Diperbaiki'] ?? 0 }}</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-america"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-danger" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="{{asset('dist/assets/static/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Rusak</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">{{ $jumlahPerKondisi['Rusak'] ?? 0 }}</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-indonesia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Detail Stok Barang</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Jumlah Keluar</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $currentKategori = null;
                        $counter = 1;
                    @endphp
        
                    @foreach ($stokBarang as $index => $barang)
                        <tr>
                             <td class="text-center">{{ $counter++ }}</td> 
                            <td>{{ $barang->kategori->nama_kategori_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td class="text-center">{{ $barang->jumlah_masuk }}</td>
                            <td class="text-center">{{ $barang->jumlah_keluar }}</td>
                            <td class="text-center">{{ $barang->stok }}</td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                </table>
                
            </div>
        </div>
        
    </div>

</section>
<!-- Basic Tables end -->

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/datatables.js')}}"></script>  
<!-- Need: Apexcharts -->
<script src="{{asset ('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{asset ('dist/assets/static/js/pages/dashboard.js') }}"></script>
 </section>
    </section>
    @endsection

    