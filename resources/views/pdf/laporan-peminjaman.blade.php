<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        p {
            margin: 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        td {
            padding: 4px;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <h2>{{ $judul }}</h2>

    @if($tanggalMulai && $tanggalAkhir)
     <p style="text-align: center; margin: 0; font-size: 12px;">
        Periode: {{ $tanggalMulai }} - {{ $tanggalAkhir }}
    </p>
@endif


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Jenis</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pinjam as $index => $item)
                <tr>
                    <td style="text-align:center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ ucfirst($item->user->jenis) }}</td>
                    <td>
                        @foreach ($item->detail as $d)
                            {{ $d->buku->judul ?? '-' }}<br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->translatedFormat('d F Y') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
