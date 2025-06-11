@extends('layouts.app')

@section('title','E-Invensi-Barang Hilang')
@section('header','Berita Acara Barang Hilang')
@section('content')

 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <div class="card-body">
            <!-- Menampilkan pesan sukses -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
            <!-- Filter Lokasi -->
            <div class="row mb-3 align-items-center">
                <!-- Form Filter -->
                <div class="col-md-8">
                    <form action="{{ route('hilang.index') }}" method="GET" id="filterForm" class="row g-2 mb-3">
                        <!-- Filter Lokasi -->
                        <div class="col-md-3">
                            <select id="filter-lokasi" name="lokasi" class="form-select">
                                <option value="" selected>Pilih Lokasi</option>
                                @foreach ($lokasi as $loc)
                                    <option value="{{ $loc->id_lokasi }}" {{ request('lokasi') == $loc->id_lokasi ? 'selected' : '' }}>
                                        {{ $loc->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Filter Tahun -->
                        <div class="col-md-3">
                            <select id="filter-tahun" name="tahun" class="form-select">
                                <option value="" selected>Pilih Tahun</option>
                                @foreach (range(date('Y') - 10, date('Y')) as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Filter Bulan -->
                        <div class="col-md-3">
                            <select id="filter-bulan" name="bulan" class="form-select">
                                <option value="" selected>Pilih Bulan</option>
                                @foreach (range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Tombol Filter -->
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('hilang.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                    
                </div>
                <!-- Tombol Cetak dan Tambah -->
                <div class="col-md-4 text-end">
                    <a href="{{ route('hilang.create') }}" class="btn btn-success me-2">Tambah Barang Hilang</a>
                    <a href="{{ route('hilang.export-pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
                </div>
            </div>
            
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Barang</th>
                            <th>Jumlah Hilang</th>
                            <th>Lokasi</th>
                            <th>Tanggal Keluar</th>
                            <th>Tanggal Hilang</th>
                            <th>Penanggung Jawab</th>
                            <th>Keterangan</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hilang as $item)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->barangKeluar->kategori->nama_kategori_barang ?? '-' }}</td>
                        <td>{{ $item->barangKeluar->barang->nama_barang ?? $item->barangKeluar->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jumlah_hilang }}</td>
                        <td>{{ $item->barangKeluar->lokasi->nama_lokasi ?? '-' }}</td>
                        <td>{{ $item->barangKeluar->tanggal_keluar ?? '-' }}</td>
                        <td>{{ $item->tanggal_hilang }}</td>
                        <td>{{ $item->barangKeluar->nama_penanggungjawab ?? '-' }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Data barang keluar tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
               
       
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


@endsection