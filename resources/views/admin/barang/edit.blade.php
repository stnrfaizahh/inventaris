@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Barang</h3>

    <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label>Kategori Barang</label>
            <select name="id_kategori_barang" class="form-control" required>
                @foreach($kategori as $item)
                    <option value="{{ $item->id_kategori_barang }}"
                        {{ $item->id_kategori_barang == $barang->id_kategori_barang ? 'selected' : '' }}>
                        {{ $item->nama_kategori_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection
