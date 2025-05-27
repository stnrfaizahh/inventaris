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

                            {{-- SCANNER --}}
                            <div class="mb-3">
                                <label for="barcode" class="form-label">Scan Barcode</label>
                                <video id="preview" style="width:100%; max-width:300px; border:1px solid #ccc;"></video>
                                <input type="hidden" id="barcode" class="form-control" readonly>
                            </div>

                            {{-- PILIH BARANG --}}
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="id_barang" class="form-label">Pilih Barang</label>
                                    <select id="id_barang" class="form-select" name="id_barang" required>
                                        <option value="" selected disabled>Pilih Barang</option>
                                        @foreach($barang as $item)
                                            <option value="{{ $item->id_barang }}"
                                                {{ old('id_barang') == $item->id_barang ? 'selected' : '' }}>
                                                {{ $item->kode_barang }} - {{ $item->nama_barang }} ({{ $item->kategori->nama_kategori_barang ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- FORM LAINNYA --}}
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sumber_barang" class="form-label">Sumber Dana</label>
                                        <input type="text" id="sumber_barang" class="form-control" placeholder="Sumber Dana"
                                            name="sumber_barang" value="{{ old('sumber_barang') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                                        <input type="number" id="jumlah_masuk" class="form-control" placeholder="Jumlah Masuk"
                                            name="jumlah_masuk" value="{{ old('jumlah_masuk') }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                        <input type="date" id="tanggal_masuk" class="form-control" name="tanggal_masuk"
                                            value="{{ old('tanggal_masuk') }}" required />
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                </div>
                            </div>

                        </div> {{-- end card-body --}}
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
        console.log('✅ Barcode berhasil terbaca:', content);
        $('#barcode').val(content);  //simpan kode_barang hasil scan

       $.ajax({
        url: `/barang/cari-barcode/${content}`,
        method: 'GET',
        success: function (res) {
            console.log("Respon dari server:", res);

            const id = res.data.id_barang;
            const exists = $(`#id_barang option[value="${id}"]`).length > 0;
            console.log("ID ditemukan di dropdown:", exists);

            if (res.status === 'success') {
    if (!exists) {
        $('#id_barang').append(
            `<option value="${res.data.id_barang}" selected>
                ${res.data.kode_barang} - ${res.data.nama_barang}
            </option>`
        );
    } else {
        $('#id_barang').val(res.data.id_barang).change();
    }
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
            scanner.start(cameras[1]); // Kamera belakang (HP)
        } else if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('Tidak ada kamera ditemukan.');
        }
    }).catch(function (e) {
        console.error(e);
        alert('Tidak bisa mengakses kamera.');
    });

     $('form').on('submit', function () {
    if (!$('#id_barang').val()) {
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
