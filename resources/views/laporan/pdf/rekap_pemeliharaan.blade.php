<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Pemeliharaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN REKAPITULASI PEMELIHARAAN BMN</div>
        <div class="subtitle">
            @if($start && $end)
                Periode: {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}
            @else
                Periode: Keseluruhan
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aset BMN (Kode)</th>
                <th>Jenis</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->asetBmn->nama_barang }} ({{ $item->asetBmn->kode_barang }})</td>
                <td style="text-transform: capitalize;">{{ $item->jenis }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                <td style="text-transform: capitalize;">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
