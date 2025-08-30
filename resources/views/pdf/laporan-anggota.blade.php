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
            @if ($jenis === 'siswa')
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>No WA</th>
                </tr>
            @elseif ($jenis === 'guru')
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIP</th>
                    <th>Alamat</th>
                    <th>No WA</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @forelse ($anggota as $index => $item)
                @if ($jenis === 'siswa')
                    <tr>
                        <td style="text-align:center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nisn ?? '-' }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->telepon }}</td>
                    </tr>
                @elseif ($jenis === 'guru')
                    <tr>
                        <td style="text-align:center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->telepon ?? '-' }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="{{ $jenis === 'siswa' ? 6 : 5 }}" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
