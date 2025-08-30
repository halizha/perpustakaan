<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota & Tata Tertib Perpustakaan</title>
    <style>
        /* Reset untuk printing - A4 Portrait dengan margin kecil */
        @page {
            size: A4 portrait;
            margin: 2mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
                width: 210mm;
                height: 297mm;
            }

            .main-table {
                width: 190mm !important;
                page-break-inside: avoid;
                margin: 0 auto !important;
            }

            .card,
            .rules-card {
                box-shadow: none !important;
                border: 1px solid #999 !important;
            }
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            margin: 0;
            padding: 10mm;
            width: 190mm;
            min-height: 277mm;
            box-sizing: border-box;
        }

        .main-table {
            width: 170mm;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0 auto;
        }

        .main-table td {
            vertical-align: top;
            padding: 0;
        }

        .card-cell {
            width: 80mm;
        }

        .spacer-cell {
            width: 10mm !important;
        }

        .main-table {
            border-collapse: separate;
            border-spacing: 0 2mm;
            /* jarak horizontal=0, vertical=5mm */
        }

        /* Kartu Tata Tertib */
        .rules-card {
            width: 80mm;
            height: 60mm;
            background: white;
            border: 1px solid #2c3e50;
            border-radius: 3px;
            padding: 2mm;
            box-sizing: border-box;
        }

        .rules-header {
            text-align: center;
            margin-bottom: 1.5mm;
            padding-bottom: 1mm;
            border-bottom: 1px solid #3498db;
        }

        .rules-header h1 {
            font-size: 8pt;
            margin: 0;
            color: #2c3e50;
            font-weight: bold;
            line-height: 1.2;
        }

        .rules-header p {
            font-size: 7pt;
            margin: 0.5mm 0 0 0;
            color: #2c3e50;
        }

        .rules-content {
            font-size: 7pt;
            line-height: 1.3;
            margin-bottom: 1mm;
        }

        .rules-list {
            padding-left: 4mm;
            margin: 1mm 0;
        }

        .rules-list li {
            margin-bottom: 0.8mm;
            text-align: justify;
        }

        .rules-footer {
            margin-top: 9mm;
            padding-top: 1mm;
            border-top: 1px solid #ecf0f1;
            font-size: 5pt;
            color: #2c3e50;
            text-align: center;
        }

        /* Kartu Anggota */
        .card {
            width: 80mm;
            height: 60mm;
            background: white;
            border: 1px solid #2c3e50;
            border-radius: 3px;
            padding: 2mm;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 1.5mm;
            padding-bottom: 1mm;
            border-bottom: 1px solid #3498db;
        }

        .header h1 {
            font-size: 8pt;
            margin: 0;
            color: #2c3e50;
            font-weight: bold;
            line-height: 1.2;
        }

        .header p {
            font-size: 7pt;
            margin: 0.5mm 0 0 0;
            color: #2c3e50;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1mm;
            margin-top: 3mm;
        }

        .photo-cell {
            width: 20mm;
            vertical-align: top;
            padding-right: 1mm;
        }

        .info-cell {
            vertical-align: top;
        }

        .photo-container {
            text-align: center;
        }

        .photo-frame {
            width: 18mm;
            height: 24mm;
            border: 1px solid #bdc3c7;
            background: #ecf0f1;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-label {
            font-size: 5pt;
            color: #7f8c8d;
            margin-top: 0.5mm;
        }

        .info-content {
            font-size: 7pt;
        }

        .info-row {
            margin-bottom: 0.5mm;
            display: block;
            margin-left: 2mm;
        }

        .info-label {
            font-weight: bold;
            color: #2c3e50;
            display: inline-block;
            width: 15mm;
        }

        .info-value {
            color: #2c3e50;
            display: inline-block;
        }

        .footer {
            margin-top: 1.5mm;
            padding-top: 1mm;
            border-top: 1px solid #ecf0f1;
            font-size: 5pt;
            color: #e74c3c;
            text-align: center;
        }

        .member-id {
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 0.5mm;
        }

        .print-info {
            text-align: center;
            font-size: 7pt;
            color: #7f8c8d;
            margin-top: 5mm;
            padding: 2mm;
        }
    </style>
</head>

<body>
    <table class="main-table">
        @foreach ($guru as $item)
            <tr>
                <!-- Kartu Tata Tertib (belakang) -->
                <td class="card-cell">
                    <div class="rules-card">
                        <div class="rules-header">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="width:12mm; text-align:center; vertical-align:middle;">
                                        <img src="{{ public_path('assets/logo.png') }}" alt="Logo Sekolah"
                                            style="height:29px; width:auto;">
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <h1 style="margin:0; font-size:8pt; font-weight:bold;">
                                            TATA TERTIB PERPUSTAKAAN
                                        </h1>
                                        <p style="margin:0; font-size:7pt; color:#7f8c8d;">
                                            SMA NEGERI 1 BUMIAYU
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="rules-content">
                            <ol class="rules-list">
                                <li>Kartu anggota harus dibawa setiap berkunjung</li>
                                <li>Dilarang meminjamkan kartu kepada orang lain</li>
                                <li>Maksimal pinjam 5 buku selama 14 hari</li>
                                <li>Denda keterlambatan Rp 500/hari/buku</li>
                                <li>Jaga ketenangan di area perpustakaan</li>
                                <li>Dilarang merokok, makan, dan minum</li>
                                <li>Laporkan kehilangan kartu segera</li>
                                <li>Buku rusak harus diganti baru</li>
                            </ol>
                        </div>

                        <div class="rules-footer">
                            <div>Jl. P. Diponegoro No. 02, Bumiayu, Taloksari, Kec. Bumiayu, Kab. Brebes, Jawa Tengah 52273</div>
                            </div>
                    </div>
                </td>

                <!-- Kartu Anggota (depan) -->
                <td class="card-cell">
                    <div class="card">
                        <div class="header">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="width:12mm; text-align:center; vertical-align:middle;">
                                        <img src="{{ public_path('assets/logo.png') }}" alt="Logo Sekolah"
                                            style="height:29px; width:auto;">
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <h1 style="margin:0; font-size:8pt; font-weight:bold;">
                                            KARTU ANGGOTA PERPUSTAKAAN
                                        </h1>
                                        <p style="margin:0; font-size:7pt; color:#7f8c8d;">
                                            SMA NEGERI 1 BUMIAYU
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <table class="content-table">
                            <tr>
                                <td class="photo-cell">
                                    <div class="photo-container">
                                        <div class="photo-frame">
                                            <img src="{{ public_path('storage/profile/' . $item->id . '.jpg') }}"
                                                alt="Foto anggota perpustakaan"
                                                style="width:72px; height:96px; object-fit:cover;"
                                                onerror="this.src='https://placehold.co/72x96'">
                                        </div>
                                    </div>
                                </td>
                                <td class="info-cell">
                                    <div class="info-content">
                                        <div class="info-row">
                                            <span class="info-label">NIP:</span>
                                            <span class="info-value">{{ $item->nip }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Nama:</span>
                                            <span class="info-value">{{ $item->nama }}</span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <span class="info-label">Alamat:</span>
                                            <span class="info-value">{{ $item->alamat }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- TTD + Barcode -->
                        <table style="width:100%; margin-top:5px;">
                            <tr>
                                <td style="text-align:center; vertical-align:bottom; width:50%;">
                                    <div style="font-size:5pt; margin-bottom:1px;">
                                        Brebes, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                                    </div>
                                    <div style="font-size:5pt; margin-bottom:12px;">Kepala Perpustakaan</div>
                                    <div style="font-size:5pt; font-weight:bold; text-decoration:underline;">
                                        Zaenuddin, S.Ag
                                    </div>
                                    <div style="font-size:5pt;">NIP. 1970060720232 1002</div>
                                </td>
                                <td style="width:50%; text-align:right; vertical-align:bottom; padding-right:5px;">
                                    <div class="barcode-container" style="text-align:right; margin:0;">
                                        <div style="display:inline-block;">
                                            {!! DNS1D::getBarcodeHTML($item->nip, 'C128', 0.9, 18) !!}
                                            <div style="font-size:4pt; margin-top:2px; text-align:center;">
                                                {{ $item->nip }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="footer">
                            <div>Kartu wajib dibawa saat berkunjung</div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</body>


</html>
