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
    {{-- Pesan error setelah melakukan tindakan --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row mb-3">
                
                <div class="col-12 text-end">
                <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary">Tambah</a> <!-- Button Add with Link -->
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
                        <td>{{ $barang->nama_barang }}</td>

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
            
        <!-- Modal Edit Barang Masuk -->

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