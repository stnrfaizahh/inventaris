@extends('layouts.app')

@section('title', 'Scan Barcode Barang Keluar')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📦 Scan Barcode Barang Keluar</h3>

    <!-- Loader -->
    <div id="loading" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.8); z-index:9999; text-align:center; padding-top:20%;">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2">Memproses data barcode...</p>
    </div>

    <div class="row">
        <!-- Kamera Preview -->
        <div class="col-md-5 text-center">
            <video id="preview" style="width: 100%; max-width: 360px; border-radius: 10px; border: 3px solid #007bff; box-shadow: 0 0 10px rgba(0,0,0,0.1);"></video>
        </div>

        <!-- Input Manual -->
        <div class="col-md-7">
            <form method="GET" action="{{ route('scan-barcode.index') }}">
                <div class="form-group">
                    <label for="manual"><strong>Input Barcode Manual:</strong></label>
                    <input type="text" name="barcode" id="manual" class="form-control" placeholder="Masukkan kode barang" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">🔍 Cari Barang</button>
            </form>
        </div>
    </div>

    <!-- Hasil Pencarian -->
    @if($barang)
    <div class="card shadow mt-4">
        <div class="card-header bg-primary text-white">
            <strong>✅ Data Barang Ditemukan</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2"><strong>Kode Barang:</strong> {{ $barang->kode_barang_keluar }}</div>
                <div class="col-md-6 mb-2"><strong>Nama Barang:</strong> {{ $barang->barang->nama_barang ?? '-' }}</div>
                <div class="col-md-6 mb-2"><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori_barang ?? '-' }}</div>
                <div class="col-md-6 mb-2"><strong>Jumlah Keluar:</strong> {{ $barang->jumlah_keluar ?? '-' }}</div>
                <div class="col-md-6 mb-2"><strong>Tanggal Keluar:</strong> {{ $barang->tanggal_keluar }}</div>
                <div class="col-md-6 mb-2"><strong>Tanggal Exp:</strong> {{ $barang->tanggal_exp }}</div>
                <div class="col-md-6 mb-2"><strong>Lokasi:</strong> {{ $barang->lokasi->nama_lokasi ?? '-' }}</div>
                <div class="col-md-6 mb-2"><strong>Kondisi:</strong> {{ $barang->kondisi }}</div>
                <div class="col-md-6 mb-2"><strong>Penanggung Jawab:</strong> {{ $barang->nama_penanggungjawab ?? '-' }}</div>
            </div>
        </div>
    </div>
@elseif($barcode)
    <script>
        alert("❌ Barcode {{ $barcode }} tidak ditemukan dalam data barang keluar!");
    </script>
    <div class="alert alert-danger mt-4">
        Barang dengan barcode <strong>{{ $barcode }}</strong> tidak ditemukan.
    </div>
@endif

</div>

<!-- SCRIPT SCANNER -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/instascan.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });

        scanner.addListener('scan', function (content) {
            $('#manual').val(content);
            $('#loading').show();
            $('form').submit();
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 1) {
                scanner.start(cameras[1]);
            } else if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('❌ Tidak ada kamera ditemukan.');
            }
        }).catch(function (e) {
            console.error(e);
            alert('❌ Tidak bisa mengakses kamera.');
        });
    });
</script>

@if(request('barcode') && !session('barang'))
<script>
    $(document).ready(function () {
        $('#loading').hide();
    });
</script>
@endif

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection
