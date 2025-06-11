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
        table.tabel-barang-hilang, 
        table.tabel-barang-hilang th, 
        table.tabel-barang-hilang td {
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
            <h3>Berita Acara Barang Hilang</h3>
            <h4>
                TAHUN PELAJARAN
                {{ $hilang->isNotEmpty() ? date('Y', strtotime($hilang->first()->tanggal_hilang)) : 'Tidak Diketahui' }}/
                {{ $hilang->isNotEmpty() ? date('Y', strtotime($hilang->first()->tanggal_hilang . ' +1 year')) : '' }}
            </h4>
        </div>

        <!-- LOKASI -->
        @if(request('lokasi'))
        <p><strong>Lokasi:</strong> {{ $hilang->first()->barangkeluar->lokasi->nama_lokasi ?? 'Semua Lokasi' }}</p>
        @endif
        
        <!-- ISI -->
        <div class="content">
            <p>
                Pada hari ini <span id="hariTanggal"></span>, petugas yang bertandatangan di bawah ini 
                telah melakukan pendataan barang hilang dengan rincian sebagai berikut:
            </p>

            <table class="tabel-barang-hilang">
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
                    @foreach($hilang as $i => $item)
                        @php $bk = $item->barangKeluar; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $bk->kategori->nama_kategori_barang ?? '-' }}</td>
                            <td>{{ $bk->barang->nama_barang ?? $bk->nama_barang ?? '-' }}</td>
                            <td>{{ $item->jumlah_hilang }}</td>
                            <td>{{ $bk->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>{{ $bk->tanggal_keluar }}</td>
                            <td>{{ $item->tanggal_hilang }}</td>
                            <td>{{ $bk->nama_penanggungjawab ?? '-' }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top: 30px;">
                Demikian berita acara barang hilang ini dibuat agar dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <!-- TANDA TANGAN -->
        <div class="ttd">
            <div class="left-ttd">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <br><br><br>
                <p>___________________________</p>
                <p>Yuni Rochmulyati, S.Pd</p>
            </div>
            <div class="right-ttd">
                @if($hilang->isNotEmpty())
                    <p>Lumajang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Petugas Sarpras</p>
                    <br><br><br>
                    <p>___________________________</p>
                    <p>...............................................</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
