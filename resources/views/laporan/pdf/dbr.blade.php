<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang Ruangan (DBR)</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .info-table { width: 50%; border: none; margin-bottom: 20px; }
        .info-table td { border: none; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DAFTAR BARANG RUANGAN (DBR)</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="30%"><strong>Nama Ruangan</strong></td>
            <td>: {{ $ruangan->nama_ruangan }}</td>
        </tr>
        <tr>
            <td><strong>Gedung / Lantai</strong></td>
            <td>: {{ $ruangan->gedung ?? '-' }} / Lt. {{ $ruangan->lantai ?? '-' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>NUP</th>
                <th>Nama Barang</th>
                <th>Merk/Tipe</th>
                <th>Tahun Perolehan</th>
                <th>Kondisi/Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asets as $index => $aset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aset->kode_barang }}</td>
                <td>{{ $aset->nup ?? '-' }}</td>
                <td style="text-align: left;">{{ $aset->nama_barang }}</td>
                <td style="text-align: left;">{{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</td>
                <td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('Y') : '-' }}</td>
                <td style="text-transform: capitalize;">{{ $aset->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Belum ada aset terdaftar di ruangan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
