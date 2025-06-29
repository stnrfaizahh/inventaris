<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #ddd; }
    </style>
</head>
<body>
    <h3>Laporan Inventaris Barang di tiap lokasi</h3>
    <table>
        <thead>
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
            @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item['kategori'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['lokasi'] }}</td>
                    <td>{{ $item['penanggung_jawab'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
