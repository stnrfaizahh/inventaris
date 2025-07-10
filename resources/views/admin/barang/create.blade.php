@extends('layouts.app')

@section('title', 'E-Invensi - Data Master')
@section('header', 'Input Barang')

@section('content')
<!-- Form Tambah Barang -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data Barang</h4>
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

                        {{-- Form tambah barang --}}
                        <form action="{{ route('barang.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- Kategori Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="id_kategori_barang" class="form-label">Kategori Barang</label>
                                        <select name="id_kategori_barang" id="id_kategori_barang" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategori as $item)
                                                <option value="{{ $item->id_kategori_barang }}">{{ $item->nama_kategori_barang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Nama Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    <a href="{{ route('barang.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>
@endsection
