<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>
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

        table.tabel-inventaris, 
        table.tabel-inventaris th, 
        table.tabel-inventaris td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .ttd-wrapper {
            margin-top: 30px;
            page-break-inside: avoid;
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
        <div class="kop-surat">
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
            <hr style="border: 2px solid black; margin: 5px 0 10px 0;">
        </div>

        <!-- JUDUL -->
        <div style="text-align: center; margin-bottom: 10px;">
            <h3>Laporan Inventaris Barang</h3>
        </div>

        <!-- FILTER INFO -->
        <h4 style="text-align: left">
            @if(isset($lokasiId) && $lokasiId) 
                Lokasi: {{ $data[0]['lokasi'] ?? 'Tidak Diketahui' }} 
            @else 
                Semua Lokasi 
            @endif

            @if(isset($kategoriId) && $kategoriId) 
                | Kategori: {{ $data[0]['kategori'] ?? 'Semua Kategori' }} 
            @endif
        </h4>

        <!-- TABEL -->
        <table class="tabel-inventaris">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Lokasi</th>
                    <th>Penanggung Jawab</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
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
                        <td colspan="6">Tidak ada data inventaris tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TTD -->
        <div class="ttd-wrapper">
            <div class="ttd">
                <div class="left-ttd">
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                    <br><br>
                    <p>___________________________</p>
                    <p>Yuni Rochmulyati, S.Pd</p>
                </div>
                <div class="right-ttd">
                    <p>Lumajang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    @if(isset($lokasiId) && $lokasiId && !empty($data)) 
                        <p>Penanggung Jawab Lokasi:</p>
                        <br><br>
                        <p>___________________________</p>
                        <p>{{ $data[0]['penanggung_jawab'] ?? '...........................' }}</p>
                    @else
                        <p>Penanggung Jawab Lokasi:</p>
                        <br><br>
                        <p>___________________________</p>
                        <p>...........................</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
