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
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .kop-surat img {
            width: 130px;
            height: 130px;
            margin-right: 20px;
        }

        .kop-surat .text {
            flex: 1;
            text-align: center;
        }

        .kop-surat h2, .kop-surat h3, .kop-surat h4, .kop-surat p {
            margin: 0;
        }

        hr.garis-kop {
            border: 2px solid black;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.tabel-barang-masuk, 
        table.tabel-barang-masuk th, 
        table.tabel-barang-masuk td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            text-align: center;
        }

        .ttd div {
            display: inline-block;
            width: 45%;
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
        <!-- KOP SURAT -->
      <div class="kop-surat" style="margin-bottom: 10px;">
    <table style="width: 100%; margin-bottom: 5px;">
        <tr>
            <td style="width: 90px;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo Sekolah" width="90">
            </td>
            <td style="text-align: center;">
                <div style="line-height: 1.3;">
                    <h3 style="margin: 0;">YAYASAN NURUL MASYITHAH LUMAJANG (YNML)</h3>
                    <h2 style="margin: 0;">SEKOLAH DASAR ISLAM TOMPOKERSAN LUMAJANG</h2>
                    <p style="margin: 0;"><em>(FULL DAY SCHOOL – FULL DAY EDUCATION)</em></p>
                    <p style="margin: 0;"><strong>TAQWA - TERAMPIL - UNGGUL</strong></p>
                    <p style="margin: 0; font-size: 11px;">
                        Jl. Kapten Kyai Ilyas 12 Telp. (0334) 882547, Fax 893789 Lumajang <br>
                        Website: https://www.sditompokersan.sch.id | Email: sdi.tompokersanlumajang@gmail.com <br>
                        NPSN: 20521342 | NSS: 102052110025
                    </p>
                </div>
            </td>
        </tr>
    </table>


    <!-- Garis pemisah tunggal -->
    <hr style="border: 2px solid black; margin: 5px 0 10px 0;">
</div>

        <!-- JUDUL DOKUMEN -->
        <div style="text-align: center; margin-bottom: 10px;">
            <h3>Laporan Barang Masuk</h3>
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
        <table class="tabel-barang-masuk">
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
                        <td>{{ $item->barang->nama_barang }}</td>
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
                    <p>...........................</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
