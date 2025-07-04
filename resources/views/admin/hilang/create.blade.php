@extends('layouts.app')

@section('title','E-Invensi - Barang Hilang')
@section('header','Input Barang Hilang')
@section('content')

<section id="form-barang-hilang">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <form action="{{ route('hilang.store') }}" method="POST">
              @csrf

              @if (session('error'))
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

              {{-- Filter Kategori dan Nama Barang --}}
                <div class="row mb-3">
                <div class="col-md-6">
                  <label for="kategori_barang">Kategori Barang</label>
                  <select id="kategori_barang" class="form-control">
                    <option value="" selected disabled>-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                      <option value="{{ $item->id_kategori_barang }}">{{ $item->nama_kategori_barang }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="nama_barang">Nama Barang</label>
                  <select id="nama_barang" class="form-control">
                  <option value="" selected disabled>-- Pilih Barang --</option>
                  @php
                    $namaBarangUnik = collect($barangKeluar)->unique('id_barang');
                  @endphp
                  @foreach ($namaBarangUnik as $bk)
                    <option value="{{ $bk->id_barang }}"
                            data-kategori="{{ $bk->id_kategori_barang }}">
                      {{ $bk->barang->nama_barang }}
                    </option>
                  @endforeach
                </select>

                </div>
              </div>


              {{-- Tabel Pilihan Barang Keluar --}}
              <div class="table-responsive">
                <table class="table" id="tabel-barang-keluar">
                  <thead>
                    <tr>
                      <th>Pilih</th>
                      <th>No</th>
                      <th>Kategori</th>
                      <th>Barang</th>
                      <th>Jumlah</th>
                      <th>Kondisi</th>
                      <th>Lokasi</th>
                      <th>Tanggal Keluar</th>
                      <th>EXP</th>
                      <th>Penanggung Jawab</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($barangKeluar as $bk)
                    @php
                      $hilangManual = optional($bk->hilang)->sum('jumlah_hilang') ?? 0;
                      $hilangOtomatis = $bk->kondisi === 'HILANG' ? $bk->jumlah_keluar : 0;
                      $tersisa = $bk->jumlah_keluar - $hilangManual - $hilangOtomatis;
                    @endphp
                    <tr data-kategori="{{ $bk->id_kategori_barang }}" data-nama="{{ $bk->id_barang }}" data-tersisa="{{ $tersisa }}">
                      <td>
                        @if ($tersisa > 0)
                          <input type="radio" name="id_barang_keluar" value="{{ $bk->id_barang_keluar }}">
                        @else
                          <span class="text-danger">Habis</span>
                        @endif
                      </td>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $bk->kategori->nama_kategori_barang }}</td>
                      <td>{{ $bk->barang->nama_barang }}</td>
                      <td>{{ $bk->jumlah_keluar }}</td>
                      <td>{{ ucfirst($bk->kondisi) }}</td>
                      <td>{{ $bk->lokasi->nama_lokasi }}</td>
                      <td>{{ $bk->tanggal_keluar }}</td>
                      <td>{{ $bk->tanggal_exp }}</td>
                      <td>{{ $bk->nama_penanggungjawab }}</td>
                    </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>

              <hr>

              {{-- Form Detail --}}
              <div class="row">
                <div class="col-md-6">
                  <label>Jumlah Hilang</label>
                  <input type="number" name="jumlah_hilang" class="form-control" required min="1">
                </div>
                <div class="col-md-6">
                  <label>Tanggal Hilang</label>
                  <input type="date" name="tanggal_hilang" class="form-control" value="{{old('tanggal_hilang', date('Y-m-d')) }}" required>
                </div>
              </div>

              <div class="row mt-2">
               
                <div class="col-md-12">
                  <label>Keterangan (opsional)</label>
                  <textarea name="keterangan" rows="2" class="form-control"></textarea>
                </div>
              </div>

              <div class="mt-4 d-flex justify-content-end">
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
<script>
    
    $(document).ready(function () {
  const table = $('#tabel-barang-keluar').DataTable({
    pageLength: 10,
    lengthChange: false,
    ordering: false,
    language: {
      search: "Cari:",
      paginate: {
        previous: "Sebelumnya",
        next: "Berikutnya"
      },
      emptyTable: "Tidak ada data tersedia",
      info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
      infoEmpty: "Menampilkan 0 data",
    }
  });

  let selectedKategori = '';
  let selectedNama = '';

  $('#kategori_barang').on('change', function () {
    selectedKategori = this.value;
    selectedNama = '';

    $('#nama_barang').val('');
    $('#nama_barang option').each(function () {
      const kategori = $(this).data('kategori');
      if (!kategori) return; // skip default option
      if (kategori == selectedKategori) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

    table.draw();
  });

  $('#nama_barang').on('change', function () {
    selectedNama = this.value;
    table.draw();
  });

  // Filter data di tabel berdasarkan dropdown
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    const row = table.row(dataIndex).node();
    const rowKategori = $(row).data('kategori');
    const rowNama = $(row).data('nama');
    const rowTersisa = $(row).data('tersisa');

    return (!selectedKategori || rowKategori == selectedKategori) &&
           (!selectedNama || rowNama == selectedNama) &&
           (rowTersisa > 0);
  });
});

  </script>
  
<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/datatables.js')}}"></script>  
<!-- Need: Apexcharts -->
<script src="{{asset ('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{asset ('dist/assets/static/js/pages/dashboard.js') }}"></script>

@endsection
