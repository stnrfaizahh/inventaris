@extends('layouts.app')

@section('title','E-Invensi-Data Master')
@section('header','Data Master Lokasi')
@section('content')
<section class="section">
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 d-flex justify-content-start">
            <a href="{{ route('lokasi.create') }}" class="btn btn-primary btn-sm" id="addLocationBtn">Tambah <i class="bi bi-pencil-fill"></i></a>
        </div>          
        <!-- Lokasi -->
        <div class="col-12">
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Lokasi</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lokasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_lokasi }}</td>
                    <td>{{ $item->nama_lokasi }}</td>
                        <td>
                            <a href="{{ route('lokasi.edit', $item->id_lokasi) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('lokasi.destroy', $item->id_lokasi) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</section>
<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/datatables.js')}}"></script>



@endsection
