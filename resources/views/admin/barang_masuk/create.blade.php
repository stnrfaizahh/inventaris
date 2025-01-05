@extends('layouts.app')

@section('title','E-Invensi-Barang Masuk')
@section('header','Input Barang Masuk')
@section('content')

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

{{-- Form input untuk menambah barang masuk --}}
<form action="{{ route('barang-masuk.store') }}" method="POST">
@csrf
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <!-- Form Row 1 -->
                        <div class="row">
                            <!-- Kategori -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="kategori_barang" class="form-label">Kategori</label>
                                    <select id="kategori_barang" class="form-select" name="kategori_barang" required>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        @foreach($kategori_barang as $kategori)
                                            <option value="{{ $kategori->id_kategori_barang }}" 
                                                {{ old('kategori_barang') == $kategori->id_kategori_barang ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Barang -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" id="nama_barang" class="form-control" placeholder="Barang" 
                                           name="nama_barang" value="{{ old('nama_barang') }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Form Row 2 -->
                        <div class="row">
                            <!-- Sumber Dana -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sumber_barang" class="form-label">Sumber Dana</label>
                                    <input type="text" id="sumber_barang" class="form-control" placeholder="Sumber Dana" 
                                           name="sumber_barang" value="{{ old('sumber_barang') }}" required />
                                </div>
                            </div>
                            <!-- Jumlah -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                                    <input type="number" id="jumlah_masuk" class="form-control" placeholder="Jumlah Masuk" 
                                           name="jumlah_masuk" value="{{ old('jumlah_masuk') }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Form Row 3 -->
                        <div class="row">
                            <!-- Kondisi -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="kondisi" class="form-label">Kondisi</label>
                                    <select id="kondisi" class="form-control" name="kondisi" required>
                                        <option value="" disabled selected>Pilih Kondisi</option>
                                        <option value="Baru" {{ old('kondisi') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="Diperbaiki" {{ old('kondisi') == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Lokasi -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <select id="lokasi" class="form-select" name="lokasi" required>
                                        <option value="" selected disabled>Pilih Lokasi</option>
                                        @foreach($lokasi as $lok)
                                            <option value="{{ $lok->id_lokasi }}" 
                                                {{ old('lokasi') == $lok->id_lokasi ? 'selected' : '' }}>
                                                {{ $lok->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Form Row 4 -->
                        <div class="row">
                            <!-- Tanggal -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" id="tanggal_masuk" class="form-control" name="tanggal_masuk" 
                                           value="{{ old('tanggal_masuk') }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Submit & Reset Buttons -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                <a href="{{ route('barang-masuk.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
</div>

  
    <!-- // Basic multiple Column Form section end -->
  </div>

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection