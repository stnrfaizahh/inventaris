@extends('layouts.app')

@section('title', 'E-Invensi-Data Master')
@section('header', 'Input Kategori')
@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Kategori</h4>
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

                        {{-- Form untuk menambah kategori --}}
                        <form action="{{ route('kategori.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- Kode Kategori --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kode_kategori">Kode Kategori</label>
                                        <input type="text" name="kode_kategori" id="kode_kategori" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Nama Kategori Barang --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_kategori_barang">Nama Kategori</label>
                                        <input type="text" name="nama_kategori_barang" id="nama_kategori_barang" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        
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

