@extends('layouts.app')

@section('title','E-Invensi-Barang Keluar')
@section('header','Edit Barang Keluar')
@section('content')


<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <span class="icon">⚠️</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    
                    <h4 class="card-title">Edit Barang Keluar</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('barang-keluar.update', $barangKeluar->id_barang_keluar) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Kategori Barang -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                        <select name="kategori_barang" id="kategori_barang" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori_barang as $kategori)
                                                <option value="{{ $kategori->id_kategori_barang }}" {{ $barangKeluar->id_kategori_barang == $kategori->id_kategori_barang ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Barang -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_barang" class="form-label">Barang</label>
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $barangKeluar->nama_barang }}" required>
                                    </div>
                                </div>

                                <!-- Jumlah Keluar -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                                        <input type="number" name="jumlah_keluar" id="jumlah_keluar" class="form-control" value="{{ $barangKeluar->jumlah_keluar }}" required>
                                    </div>
                                </div>

                                <!-- Kondisi Barang -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kondisi" class="form-label">Kondisi Barang</label>
                                        <select name="kondisi" id="kondisi" class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="baru" {{ $barangKeluar->kondisi == 'baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="rusak" {{ $barangKeluar->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="hilang" {{ $barangKeluar->kondisi == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <select name="lokasi" id="lokasi" class="form-control" required>
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $loc)
                                                <option value="{{ $loc->id_lokasi }}" {{ $barangKeluar->id_lokasi == $loc->id_lokasi ? 'selected' : '' }}>
                                                    {{ $loc->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tanggal Keluar -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ $barangKeluar->tanggal_keluar }}" required>
                                    </div>
                                </div>

                                <!-- Masa Pakai -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="masa_pakai" class="form-label">Masa Pakai (dalam bulan)</label>
                                        <input type="number" name="masa_pakai" id="masa_pakai" class="form-control" value="{{ old('masa_pakai', $barangKeluar->masa_pakai) }}" required>
                                    </div>
                                </div>

                                <!-- Penanggung Jawab -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_penanggungjawab" class="form-label">Penanggung Jawab</label>
                                        <input type="text" name="nama_penanggungjawab" id="nama_penanggungjawab" class="form-control" value="{{ $barangKeluar->nama_penanggungjawab }}" required>
                                    </div>
                                </div>

                                <!-- Tombol Simpan -->
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Perubahan</button>
                                    <a href="{{ route('barang-keluar.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection