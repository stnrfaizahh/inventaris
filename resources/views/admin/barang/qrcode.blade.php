<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Label Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 1px;
            margin: 0;
            padding: 0;
        }
        .label {
            border: 1px solid #000;
            width: 48%;
            height: 110px;
            display: table;
            table-layout: fixed;
            border-collapse: collapse;
            margin: 1%;
            box-sizing: border-box;
            /* float: left; */
        }
        .row-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        }

        .cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 5px;
            border-right: 1px solid #000;
        }
        .cell:last-child {
            border-right: none;
        }
        .logo img {
            max-width: 70px;
            height: auto;
        }
        .logo-text {
            font-size: 8px;
            margin-top: 3px;
        }
        .info h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .info h4 {
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: bold;
        }
        .qr img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>

@foreach ($barangList as $index => $barang)
    @if ($index % 2 == 0)
    <div class="row-label">
    @endif
<div class="label">
    {{-- Kolom Logo --}}
    <div class="cell logo">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <div class="logo-text"> SD Islam Tompokersan </div>
        <div class="logo-text">  Lumajang</div>
    </div>

    {{-- Kolom Informasi Barang --}}
    <div class="cell info">
        <h2>{{ $barang->kode_barang }}</h2>
        <br>
        <hr style="border: none; border-top: 1px solid #000;">
        <br>
        <h4>{{ $barang->nama_barang }}</h4>
    </div>

    {{-- Kolom QR Code --}}
    <div class="cell qr">
        @php
        $qr = base64_encode(QrCode::format('svg')->size(100)->generate($barang->barcode));
    @endphp
    
    <img src="data:image/png;base64, {!! $qr !!}" width="100">
    
    </div>
</div>
@if ($index % 2 == 1 || $loop->last)
</div>
@endif
@endforeach
<div style="clear: both;"></div>

</body>
</html>