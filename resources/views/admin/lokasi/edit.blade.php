@extends('layouts.app')

@section('title', 'E-Invensi-Data Master')
@section('header', 'Edit Lokasi')
@section('content')
<!-- // Basic multiple Column Form section start -->

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Lokasi</h4>
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

                        {{-- Form untuk mengedit lokasi --}}
                        <form method="POST" action="{{ route('lokasi.update', $lokasi->id_lokasi) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Kode Lokasi --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kode_lokasi">Kode Lokasi</label>
                                        <input type="text" id="kode_lokasi" name="kode_lokasi" class="form-control" value="{{ $lokasi->kode_lokasi }}" required>
                                    </div>
                                </div>

                                {{-- Nama Lokasi --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama_lokasi">Nama Lokasi</label>
                                        <input type="text" id="nama_lokasi" name="nama_lokasi" class="form-control" value="{{ $lokasi->nama_lokasi }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Update --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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

<!-- // Basic multiple Column Form section end -->
@endsection

