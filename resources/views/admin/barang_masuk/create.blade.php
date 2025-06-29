@extends('layouts.app')

@section('title','E-Invensi-Barang Masuk')
@section('header','Input Barang Masuk')
@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('barang-masuk.store') }}" method="POST">
    @csrf
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                {{-- Kolom Video Scanner --}}
                                <div class="col-md-4 col-12 mb-4">
                                    <label for="barcode" class="form-label">Scan Barcode</label>
                                    <video id="preview" style="width:100%; border:1px solid #ccc; border-radius:8px;"></video>
                                    <input type="hidden" id="barcode" class="form-control" readonly>
                                </div>

                                {{-- Kolom Form --}}
                                <div class="col-md-8 col-12">
                                    {{-- Pilih Barang --}}
                                    <div class="form-group mb-3">
                                        <label for="id_barang" class="form-label">Pilih Barang</label>
                                        <select id="id_barang" class="form-select" required>
                                            <option value="" selected disabled>-- Pilih Barang --</option>
                                            @foreach($barang as $item)
                                                <option value="{{ $item->id_barang }}"
                                                    {{ old('id_barang') == $item->id_barang ? 'selected' : '' }}>
                                                    {{ $item->kode_barang }} - {{ $item->nama_barang }} ({{ $item->kategori->nama_kategori_barang ?? '-' }})
                                                </option>
                                            @endforeach
                                        </select>
                                          {{-- Hidden input untuk dikirim ke server --}}
                                            <input type="hidden" name="id_barang" id="id_barang_hidden">
                                            <button type="button" id="ubah-barang" class="btn btn-warning btn-sm mt-2">Ubah Barang</button>
                                    </div>

                                    {{-- Baris: Sumber Dana & Jumlah Masuk --}}
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="sumber_barang" class="form-label">Sumber Dana</label>
                                            <input type="text" id="sumber_barang" class="form-control" placeholder="Sumber Dana"
                                                name="sumber_barang" value="{{ old('sumber_barang') }}" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                                            <input type="number" id="jumlah_masuk" class="form-control" placeholder="Jumlah Masuk"
                                                name="jumlah_masuk" value="{{ old('jumlah_masuk') }}" required />
                                        </div>
                                    </div>

                                    {{-- Baris: Kondisi & Lokasi --}}
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="kondisi" class="form-label">Kondisi</label>
                                            <select id="kondisi" class="form-control" name="kondisi" required>
                                                <option value="" disabled selected>Pilih Kondisi</option>
                                                <option value="Baru" {{ old('kondisi') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                                <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="Diperbaiki" {{ old('kondisi') == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
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

                                    {{-- Tanggal Masuk --}}
                                    <div class="mb-3">
                                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                        <input type="date" id="tanggal_masuk" class="form-control" name="tanggal_masuk"
                                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required />
                                    </div>
                                </div>
                            </div>

    {{-- Tombol --}}
    <div class="row mt-3">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
            <a href="{{ route('barang-masuk.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        </div>
    </div>
</div>
 {{-- end card-body --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

{{-- JS Tambahan --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/instascan.min.js') }}"></script>
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });

    scanner.addListener('scan', function (content) {
        if ($('#id_barang').prop('disabled')) {
            console.log('📛 Scan diabaikan karena dropdown terkunci');
            return; // Abaikan scan jika dropdown sudah dikunci
        }

        console.log('✅ Barcode terbaca:', content);
        $('#barcode').val(content);

        $.ajax({
            url: `/barang/cari-barcode/${content}`,
            method: 'GET',
            success: function (res) {
                if (res.status === 'success') {
                    const id = res.data.id_barang;
                    const exists = $(`#id_barang option[value="${id}"]`).length > 0;

                    if (!exists) {
                        $('#id_barang').append(
                            `<option value="${id}" selected>${res.data.kode_barang} - ${res.data.nama_barang}</option>`
                        );
                    } else {
                        $('#id_barang').val(id).trigger('change');
                    }

                    $('#id_barang_hidden').val(id); // set hidden input
                    $('#id_barang').prop('disabled', true); // lock dropdown

                    alert(`✅ Barang ditemukan: ${res.data.kode_barang} - ${res.data.nama_barang}`);
                } else {
                    alert('⚠️ Barang tidak ditemukan.');
                }
            },
            error: function () {
                alert('❌ Gagal mencari barang.');
            }
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

    // Saat dropdown berubah, update hidden input
    $('#id_barang').on('change', function () {
        $('#id_barang_hidden').val($(this).val());
    });

    // Tombol ubah barang: aktifkan kembali dropdown
    $('#ubah-barang').on('click', function () {
        $('#id_barang').prop('disabled', false);
    });

    // Validasi saat submit
    $('form').on('submit', function () {
        if (!$('#id_barang_hidden').val()) {
            alert('❌ Barang belum dipilih. Silakan scan atau pilih manual.');
            return false;
        }
    });
</script>

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>
@endsection
