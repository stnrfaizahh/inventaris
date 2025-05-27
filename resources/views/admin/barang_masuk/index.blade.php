@extends('layouts.app')

@section('title','E-Invensi-Barang Masuk')
@section('header','Data Barang Masuk')
@section('content')

 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <div class="card-body">
    {{-- Pesan sukses setelah melakukan tindakan --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Tampilkan error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     <!-- Filter Lokasi -->
     <div class="row mb-3 align-items-center">
        <!-- Form Filter -->
        <div class="col-md-8">
            <form action="{{ route('barang-masuk.index') }}" method="GET" id="filterForm" class="row align-items-end g-2 mb-3">
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
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
            
        </div>
         <!-- Tombol Cetak dan Tambah -->
         <div class="col-md-4 text-end">
            <a href="{{ route('barang-masuk.export-pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>

            <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary">Tambah</a>
        </div>
    </div>
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Barang</th>
                            <th>Sumber Dana</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangMasuk as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- Menampilkan nama kategori barang --}}
                        <td>{{ $barang->kategori->nama_kategori_barang }}</td>

                            {{-- Menampilkan nama barang --}}
                        <td>{{ $barang->barang->nama_barang ?? '-' }}</td>

                            {{-- Menampilkan sumber barang --}}
                        <td>{{ $barang->sumber_barang }}</td>
                            {{-- Menampilkan jumlah barang masuk --}}
                        <td>{{ $barang->jumlah_masuk }}</td>

                            {{-- Menampilkan kondisi barang --}}
                        <td>{{ $barang->kondisi }}</td>
                            {{-- Menampilkan nama lokasi --}}
                        <td>{{ $barang->lokasi->nama_lokasi }}</td>
                           {{-- Menampilkan tanggal masuk --}}
                        <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d-m-Y') }}</td>

                            <td>
                                <a href="{{ route('barang-masuk.edit', $barang->id_barang_masuk) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            
                                    <form action="{{ route('barang-masuk.destroy', $barang->id_barang_masuk) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')"><i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                              </td>
                        </tr>
                        @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data barang masuk.</td>
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