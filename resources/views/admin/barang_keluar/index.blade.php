@extends('layouts.app')

@section('title','E-Invensi-Barang Keluar')
@section('header','Data Barang Keluar')
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
                    <form action="{{ route('barang-keluar.index') }}" method="GET" id="filterForm" class="row g-2 mb-3">
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
                
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                    
                </div>
                
                <div class="col-md-4 text-end">
                    <a href="{{ route('barang-keluar.export-pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
                    <a href="{{ route('barang-keluar.print-all-qr', request()->query() )}}" class="btn btn-outline-success" >Cetak Semua QR</a>
                    <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
            
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Tanggal Keluar</th>
                            <th>EXP</th>
                            <th>Penanggung Jawab</th>
                            <th>QRCode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangKeluar as $item)
                        <tr>
                        <td>{{ ($barangKeluar->currentPage() - 1) * $barangKeluar->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori_barang }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>

                        <td>{{ $item->jumlah_keluar }}</td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        <td>{{ $item->lokasi->nama_lokasi }}</td>
                        <td>{{ $item->tanggal_keluar }}</td>
                        <td>{{ $item->tanggal_exp }}</td>
                        <td>{{ $item->nama_penanggungjawab }}</td>
                        <td>
                            <div>
                                 {!! QrCode::size(80)->generate($item->kode_barang_keluar) !!}
                                  <div style="font-size: 10px">{{ $item->kode_barang_keluar }}</div>
                            </div>
                        </td>
                        <td >
                            <a href="{{ route('barang-keluar.edit', $item->id_barang_keluar) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('barang-keluar.destroy', $item->id_barang_keluar) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
                            </form>
                             <a href="{{ route('barang-keluar.print-qr', $item->id_barang_keluar) }}" class="btn btn-success btn-sm mt-1">
                                <i class="bi bi-printer-fill"></i> QR
                            </a>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">Data barang keluar tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $barangKeluar->withQueryString()->links() }}
                </div>
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