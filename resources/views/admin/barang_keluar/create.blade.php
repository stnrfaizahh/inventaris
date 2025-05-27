@extends('layouts.app')

@section('title','E-Invensi - Barang Keluar')
@section('header','Input Barang Keluar')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" action="{{ route('barang-keluar.store') }}" method="POST">
                            @csrf

                            {{-- Alert Error --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <span class="icon">⚠️</span> {{ session('error') }}
                                </div>
                            @endif

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

                            {{-- Baris 1: Barcode dan Pilih Barang --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="barcode" class="form-label">Scan Barcode Barang</label>
                                        <video id="preview" style="width:100%; max-width:300px; border:1px solid #ccc;"></video>
                                        <input type="hidden" id="barcode" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_barang" class="form-label">Pilih Barang</label>
                                        <select id="id_barang" name="id_barang" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Barang --</option>
                                            @foreach($barangMasuk as $barang)
                                                <option value="{{ $barang->id_barang }}" data-kode="{{ $barang->kode_barang }}">
                                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Informasi Barang --}}
                            <div id="info-barang" class="alert alert-info mt-3" style="display: none;">
                                <p><strong>Nama Barang:</strong> <span id="nama-barang-info"></span></p>
                                <p><strong>Kategori:</strong> <span id="kategori-barang-info"></span></p>
                                <p><strong>Stok Tersedia:</strong> <span id="stok-barang-info"></span></p>
                            </div>

                            {{-- Baris 2: Penanggung Jawab & Jumlah --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_penanggungjawab" class="form-label">Penanggung Jawab</label>
                                        <input type="text" id="nama_penanggungjawab" name="nama_penanggungjawab" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                                        <input type="number" id="jumlah_keluar" name="jumlah_keluar" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Baris 3: Kondisi & Lokasi --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kondisi" class="form-label">Kondisi Barang</label>
                                        <select id="kondisi" name="kondisi" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Kondisi --</option>
                                            <option value="baru">Baru</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <select id="lokasi" name="lokasi" class="form-control" required>
                                            <option value="" disabled selected>Pilih Lokasi</option>
                                            @foreach ($lokasi as $loc)
                                                <option value="{{ $loc->id_lokasi }}">{{ $loc->nama_lokasi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Baris 4: Tanggal & Masa Pakai --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                                        <input type="date" id="tanggal_keluar" name="tanggal_keluar" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="masa_pakai" class="form-label">Masa Pakai (bulan)</label>
                                        <input type="number" id="masa_pakai" name="masa_pakai" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{ route('barang-keluar.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Style --}}
    <style>
        .form-label {
            font-weight: bold;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            display: flex;
            align-items: center;
        }
        .alert-danger .icon {
            margin-right: 10px;
        }
    </style>
</section>

{{-- Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/instascan.min.js') }}"></script>
<script>
    $(document).ready(function () {
        const infoBox = $('#info-barang');
        const namaBarangInfo = $('#nama-barang-info');
        const kategoriBarangInfo = $('#kategori-barang-info');
        const stokBarangInfo = $('#stok-barang-info');

        // Barcode scan event
        $('#barcode').on('change', function () {
            const kodeBarang = $(this).val();
            if (!kodeBarang) return;

            $.get(`/barang/info/${kodeBarang}`, function (data) {
                if (data.success) {
                    namaBarangInfo.text(data.nama_barang);
                    kategoriBarangInfo.text(data.kategori);
                    stokBarangInfo.text(data.stok + ' unit');
                    $('#jumlah_keluar').attr('max', data.stok);
                    infoBox.show();
                } else {
                    alert('Barang tidak ditemukan!');
                    infoBox.hide();
                }
            });
        });

        // Event saat dropdown barang dipilih
        $('#id_barang').on('change', function () {
            const idBarang = $(this).val();
            if (!idBarang) return;

         $.get(`/dashboard/stok-barang/${idBarang}`, function (data) {
                if (data.stok !== undefined) {
                    stokBarangInfo.text(data.stok + ' unit');
                    $('#jumlah_keluar').attr('max', data.stok);
                    infoBox.show();
                } else {
                    stokBarangInfo.text('Data stok tidak ditemukan');
                    infoBox.show();
                }
            }).fail(function () {
                stokBarangInfo.text('Gagal mengambil data stok');
                infoBox.show();
            });
        });

        // Scanner Barcode
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });
        scanner.addListener('scan', function (content) {
            $('#barcode').val(content).trigger('change');

            $.get(`/barang/cari-barcode/${content}`, function (res) {
                if (res.status === 'success') {
                    const id = res.data.id_barang;
                    const exists = $(`#id_barang option[value="${id}"]`).length > 0;
                    if (exists) {
                        $('#id_barang').val(id).trigger('change');
                        setTimeout(() => {
                            alert(`✅ Barang ditemukan: ${res.data.kode_barang} - ${res.data.nama_barang}`);
                        }, 300);
                    } else {
                        alert('⚠️ Barang ditemukan, tapi tidak tersedia di daftar dropdown.');
                    }
                } else {
                    alert('❌ Barang tidak ditemukan di database.');
                }
            }).fail(() => {
                alert('❌ Gagal mencari barang.');
            });
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 1) {
                scanner.start(cameras[1]);
            } else if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('Tidak ada kamera ditemukan.');
            }
        }).catch(function (e) {
            console.error(e);
            alert('Tidak bisa mengakses kamera.');
        });
    });
</script>
<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>
@endsection
