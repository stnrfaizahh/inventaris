<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Hilang</title>
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
            <h3>Berita Acara Barang Hilang</h3>
            <h4>SD ISLAM TOMPOKERSAN LUMAJANG</h4>
            <h4>TAHUN PELAJARAN {{ $barangKeluar->isNotEmpty() ? date('Y', strtotime($barangKeluar->first()->tanggal_keluar)) : 'Tidak Diketahui' }}/{{ $barangKeluar->isNotEmpty() ? date('Y', strtotime($barangKeluar->first()->tanggal_keluar . ' +1 year')) : '' }}</h4> 
        </div>
        <h4 style="text-align: left">
            @if(request('lokasi')) Lokasi: {{ $barangKeluar->first()->lokasi->nama_lokasi ?? 'Semua Lokasi' }}  @endif
        {{-- @if(request('tahun')) Tahun: {{ request('tahun') }} | @endif
        @if(request('bulan')) Bulan: {{ DateTime::createFromFormat('!m', request('bulan'))->format('F') }} @endif --}}
        </h4>
        <hr>
        <div class="content">
            <p>
                Pada hari ini <span id="hariTanggal"></span>, petugas yang bertandatangan di bawah ini 
                telah melakukan pendataan barang hilang dengan rincian sebagai berikut:
            </p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Lokasi</th>
                        <th>Tanggal Keluar</th>
                        <th>Tanggal Hilang</th>
                        <th>Penanggung Jawab</th>
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
                            <td>{{ $item->lokasi->nama_lokasi }}</td>
                            <td>{{ $item->tanggal_keluar }}</td>
                            <td>{{ $item->hilang->tanggal_hilang ?? '-' }}</td>
                            <td>{{ $item->nama_penanggungjawab }}</td>
                            <td>{{ $item->hilang->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin-top: 30px;">
                Demikian berita acara barang hilang ini dibuat agar dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>
        

        <!-- Bagian Tanda Tangan -->
        <div class="ttd">
            <div class="left-ttd">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <br><br>
                <p>___________________________</p>
                <p>Yuni Rochmulyati, S.Pd </p>
            </div>
            <div class="right-ttd">
                @if($barangKeluar->isNotEmpty())
                    <p>Lumajang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Petugas Sarpras</p>
                    <br><br>
                    {{-- <p>___________________________</p>
                    <p>{{ $barangKeluar->first()->nama_penanggungjawab }}</p>
                @else
                    <p>Petugas Sarpras</p>
                    <br><br> --}}
                    <p>___________________________</p>
                    <p>...............................................</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
