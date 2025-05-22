@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Master Barang</h3>
    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="table1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Barcode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori->nama_kategori_barang ?? '-' }}</td>
                <td>
                    {!! QrCode::size(80)->generate($item->barcode) !!}

                    {{-- <div style="font-size: 10px;">{{ $item->barcode }}</div> --}}
                </td>
                
                <td>
                    <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCetak-{{ $item->id_barang }}">
                        Cetak QR
                    </button>
                    <div class="modal fade" id="modalCetak-{{ $item->id_barang }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id_barang }}" aria-hidden="true">
                        <div class="modal-dialog">
                          <form method="POST" action="{{ route('barang.cetakSatu') }}">
                              @csrf
                              <input type="hidden" name="id_barang" value="{{ $item->id_barang }}">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalLabel-{{ $item->id_barang }}">Cetak Barcode</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $item->nama_barang }}</strong> ({{ $item->kode_barang }})</p>
                                    <label for="jumlah">Jumlah Cetak:</label>
                                    <input type="number" name="jumlah" class="form-control" required min="1" value="1">
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Cetak</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                              </div>
                          </form>
                        </div>
                    </div>
                </td>
            </tr>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            @endforeach
        </tbody>
    </table>
</div>

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>
<link rel="stylesheet" href="{{ asset('dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tampilkan Semua"]],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>

@endsection
