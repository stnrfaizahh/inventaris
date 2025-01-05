<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat h3, .kop-surat h4 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
        .container {
            position: relative;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <h2>DAFTAR INVENTARIS BARANG </h2>
            <h3>Laporan Barang Keluar</h3>
            <h4>SD ISLAM TOMPOKERSAN LUMAJANG</h4>
            <h4>TAHUN PELAJARAN {{ $barangKeluar->isNotEmpty() ? date('Y', strtotime($barangKeluar->first()->tanggal_keluar)) : 'Tidak Diketahui' }}/{{ $barangKeluar->isNotEmpty() ? date('Y', strtotime($barangKeluar->first()->tanggal_keluar . ' +1 year')) : '' }}</h4> 
        </div>
        <h4 style="text-align: left">
            @if(request('lokasi')) Lokasi: {{ $barangKeluar->first()->lokasi->nama_lokasi ?? 'Semua Lokasi' }} | @endif
        @if(request('tahun')) Tahun: {{ request('tahun') }} | @endif
        @if(request('bulan')) Bulan: {{ DateTime::createFromFormat('!m', request('bulan'))->format('F') }} @endif
        </h4>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Kondisi</th>
                    
                    <th>Tanggal Keluar</th>
                    <th>Tanggal Expired</th>
                   
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangKeluar as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah_keluar }}</td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        
                        <td>{{ $item->tanggal_keluar }}</td>
                        <td>{{ $item->tanggal_exp }}</td>
                        
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="ttd" style="position: absolute; bottom: 150px; width: 100%;">
            <div style="float: left; text-align: left;">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <br><br>
                <p>___________________________</p>
                <p>Yuni Rochmulyati, S.Pd </p>
            </div>
            <div style="float: right; text-align: right;">
        @if($barangKeluar->isNotEmpty())
            <p>Lumajang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Penanggung Jawab Lokasi:</p>
            <br><br>
            <p>___________________________</p>
            <p>{{ $barangKeluar->first()->nama_penanggungjawab }}</p>
        @else
            <p>Penanggung Jawab Lokasi:</p>
            <br><br>
            <p>___________________________</p>
            <p>...........................</p>
        @endif
        </div>
    </div>
    
    
</body>
</html>
