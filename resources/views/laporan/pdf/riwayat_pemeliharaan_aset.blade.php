<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pemeliharaan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .info-table { width: 50%; border: none; margin-bottom: 20px; }
        .info-table td { border: none; padding: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN RIWAYAT PEMELIHARAAN PER ASET</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="30%"><strong>Kode Barang</strong></td>
            <td>: {{ $aset->kode_barang }}</td>
        </tr>
        <tr>
            <td><strong>Nama Barang</strong></td>
            <td>: {{ $aset->nama_barang }}</td>
        </tr>
        <tr>
            <td><strong>Merk/Tipe</strong></td>
            <td>: {{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengajuan</th>
                <th>Jenis Pemeliharaan</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') }}</td>
                <td style="text-transform: capitalize;">{{ $item->jenis }}</td>
                <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                <td style="text-transform: capitalize;">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
