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
            width: 350px;
            height: 110px;
            display: table;
            table-layout: fixed;
            border-collapse: collapse;
            margin: 10px auto;
            box-sizing: border-box;
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
        .download-btn {
            margin: 20px;
        }
    </style>
</head>
<body>

    <div style="margin: 20px; text-align: center;">
        <button onclick="downloadLabels()" class="download-btn">Unduh QR Code Sebagai Gambar</button>
    </div>

    <div id="label-wrapper">
        @foreach ($items as $index => $barang)
            @if ($index % 2 == 0)
            <div class="row-label">
            @endif

            <div class="label">
                {{-- Kolom Logo --}}
                <div class="cell logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <div class="logo-text">SD Islam Tompokersan</div>
                    <div class="logo-text">Lumajang</div>
                </div>

                {{-- Kolom Informasi --}}
                <div class="cell info">
                    <h2>{{ $barang->kode_barang }}</h2>
                    <hr style="border: none; border-top: 1px solid #000;">
                    <h4>{{ $barang->nama_barang }}</h4>
                </div>

                {{-- Kolom QR Code --}}
                <div class="cell qr">
                    @php
                        $qrData = "Kode: {$barang->kode_barang}\nNama: {$barang->nama_barang}";
                        $qr = base64_encode(QrCode::format('png')->size(150)->margin(1)->generate($barang->barcode));
                    @endphp
                    <img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
                </div>
            </div>

            @if ($index % 2 == 1 || $loop->last)
            </div>
            @endif
        @endforeach
    </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
    function downloadLabels() {
        const labels = document.querySelectorAll('.label');
        labels.forEach((label, index) => {
            html2canvas(label, {
                scale: 4,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `label-barang-${index + 1}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    }
    </script>

</body>
</html>
