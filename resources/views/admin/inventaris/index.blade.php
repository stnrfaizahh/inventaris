@extends('layouts.app')

@section('title', 'Inventaris Barang')
@section('header', 'Inventaris Barang')

@section('content')
<div class="container mt-4">
    <form method="GET" action="{{ route('inventaris.index') }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-2">
        <select name="lokasi" class="form-select" aria-label="Pilih Lokasi">
            <option value="">Pilih Lokasi</option>
            @foreach($lokasiList as $lokasi)
                <option value="{{ $lokasi->id_lokasi }}" {{ request('lokasi') == $lokasi->id_lokasi ? 'selected' : '' }}>
                    {{ $lokasi->nama_lokasi }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="tahun" class="form-select">
            <option value="">Pilih Tahun</option>
            @foreach (range(date('Y'), date('Y') - 10) as $tahun)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="bulan" class="form-select">
            <option value="">Pilih Bulan</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-50">Filter</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary w-50">Reset</a>
    </div>

    <div class="col-md-2 d-grid">
        <a href="{{ route('inventaris.exportPdf', request()->query()) }}" class="btn btn-danger">Export PDF</a>
    </div>
</form>

    <table id="myTable" class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Penanggung Jawab</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['kategori'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['lokasi'] }}</td>
                    <td>{{ $item['penanggung_jawab'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data inventaris</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
</div>

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/datatables.js')}}"></script>

<!-- DataTables Scripts -->
<script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "lengthMenu": [10, 25, 50, 100], // Show 10, 25, 50, 100 entries
            "pageLength": 10, // Default to 10
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Tidak ada entri yang tersedia",
                "infoFiltered": "(disaring dari total _MAX_ entri)",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                }
            }
        });
    });
</script>

@endsection
