<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Masuk</title>
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
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .ttd {
            margin-top: 50px;
            text-align: center;
        }
        .container {
            position: relative;
            height: 100%;
            min-height: 100vh; /* Memastikan konten mengisi seluruh halaman */
        }
        .ttd div {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
        .left-ttd {
            text-align: left;
        }
        .right-ttd {
            text-align: right;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <h2>DAFTAR INVENTARIS BARANG </h2>
            <h3>Laporan Barang Masuk</h3>
            <h4>SD ISLAM TOMPOKERSAN LUMAJANG</h4>
            <h4>TAHUN PELAJARAN {{ $barangMasuk->isNotEmpty() ? date('Y', strtotime($barangMasuk->first()->tanggal_masuk)) : 'Tidak Diketahui' }}/{{ $barangMasuk->isNotEmpty() ? date('Y', strtotime($barangMasuk->first()->tanggal_masuk . ' +1 year')) : '' }}</h4> 
        </div>
        <h4 style="text-align: left">
            @if(request('lokasi'))
                Lokasi: {{ $barangMasuk->first()->lokasi->nama_lokasi ?? 'Semua Lokasi' }} <br>
            @endif
        
            @if(request('bulan') || request('tahun'))
            <p>
                Periode:
                @if(request('bulan'))
                    {{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}
                @endif
                @if(request('bulan') && request('tahun')) /
                @endif
                @if(request('tahun'))
                    {{ request('tahun') }}
                @endif
            </p>    
            @endif
        </h4>
        
        <hr>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Kondisi</th>
                    <th>Tanggal Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangMasuk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah_masuk }}</td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        <td>{{ $item->tanggal_masuk }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="margin-top: 10px; font-weight: bold;">
            Total Barang Masuk: {{ $barangMasuk->sum('jumlah_masuk') }}
        </p>
        

        <!-- Bagian bulan Tanda Tangan -->
        <div class="ttd">
            <div class="left-ttd">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <br><br>
                <p>___________________________</p>
                <p>Yuni Rochmulyati, S.Pd </p>
            </div>
            <div class="right-ttd">
                @if($barangMasuk->isNotEmpty())
                    <p>Lumajang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Penanggung Jawab</p>
                    <br><br>
                    <p>___________________________</p>
                    <p>{{ $barangMasuk->first()->nama_penanggungjawab }}</p>
                @else
                    <p>Penanggung Jawab:</p>
                    <br><br>
                    <p>___________________________</p>
                    <p>...........................</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
