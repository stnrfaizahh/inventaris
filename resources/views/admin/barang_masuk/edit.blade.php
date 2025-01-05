@extends('layouts.app')

@section('title','E-Invensi-Barang Masuk')
@section('header','Edit Barang Masuk')
@section('content')

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Barang Masuk</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{-- Menampilkan pesan error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form untuk mengedit barang masuk --}}
                        <form action="{{ route('barang-masuk.update', $barang->id_barang_masuk) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                {{-- Kategori Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kategori_barang">Kategori Barang</label>
                                        <select name="kategori_barang" id="kategori_barang" class="form-select" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori_barang as $kategori)
                                                <option value="{{ $kategori->id_kategori_barang }}" 
                                                        {{ $kategori->id_kategori_barang == $barang->id_kategori_barang ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                {{-- Nama Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Sumber Dana --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sumber_barang">Sumber Dana</label>
                                        <input type="text" name="sumber_barang" id="sumber_barang" class="form-control" value="{{ $barang->sumber_barang }}" required>
                                    </div>
                                </div>

                                {{-- Jumlah Barang Masuk --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="jumlah_masuk">Jumlah Masuk</label>
                                        <input type="number" name="jumlah_masuk" id="jumlah_masuk" class="form-control" value="{{ $barang->jumlah_masuk }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Kondisi Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi Barang</label>
                                        <select name="kondisi" id="kondisi" class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="Baru" {{ $barang->kondisi == 'Baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="Rusak" {{ $barang->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="Diperbaiki" {{ $barang->kondisi == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi</label>
                                        <select name="lokasi" id="lokasi" class="form-control" required>
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach($lokasi as $lok)
                                                <option value="{{ $lok->id_lokasi }}" {{ $barang->lokasi && $barang->lokasi->id_lokasi == $lok->id_lokasi ? 'selected' : '' }}>
                                                    {{ $lok->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Tanggal Masuk --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tanggal_masuk">Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ $barang->tanggal_masuk }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Perubahan</button>
                                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection