<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
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
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
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

    @if ($tanggalMulai && $tanggalAkhir)
        <p>
            Periode:
            {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }}
            -
            {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td style="text-align:center">{{ $item->jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
