@extends('layouts.app')

@section('title','E-Invensi - Edit Barang Hilang')
@section('header','Edit Barang Hilang')

@section('content')
<section id="form-barang-hilang">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">

            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('hilang.update', $hilang) }}" method="POST">
              @csrf
              @method('PUT')

              {{-- Informasi Barang (Readonly) --}}
              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Kategori Barang</label>
                  <input type="text" class="form-control" value="{{ $hilang->barangKeluar->kategori->nama_kategori_barang ?? '-' }}" readonly>
                </div>
                <div class="col-md-6">
                  <label>Nama Barang</label>
                  <input type="text" class="form-control" value="{{ $hilang->barangKeluar->barang->nama_barang ?? '-' }}" readonly>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label>Jumlah Keluar</label>
                  <input type="number" class="form-control" value="{{ $hilang->barangKeluar->jumlah_keluar }}" readonly>
                </div>
                <div class="col-md-4">
                  <label>Lokasi</label>
                  <input type="text" class="form-control" value="{{ $hilang->barangKeluar->lokasi->nama_lokasi }}" readonly>
                </div>
                <div class="col-md-4">
                  <label>Tanggal Keluar</label>
                  <input type="text" class="form-control" value="{{ $hilang->barangKeluar->tanggal_keluar }}" readonly>
                </div>
              </div>

              <hr>

              {{-- Input yang bisa diubah --}}
              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Jumlah Hilang</label>
                  <input type="number" name="jumlah_hilang" class="form-control" value="{{ old('jumlah_hilang', $hilang->jumlah_hilang) }}" required min="1">
                </div>
                <div class="col-md-6">
                  <label>Tanggal Hilang</label>
                  <input type="date" name="tanggal_hilang" class="form-control" value="{{ old('tanggal_hilang', $hilang->tanggal_hilang) }}" required>
                </div>
              </div>

              <div class="mb-3">
                <label>Keterangan (opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $hilang->keterangan) }}</textarea>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('hilang.index') }}" class="btn btn-secondary ms-2">Batal</a>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SCRIPT JS -->
<script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>
@endsection
