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
            <td><strong>Keterangan</strong></td>
            <td>: {{ $ruangan->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Total Seluruh Aset</strong></td>
            <td>: {{ $asets->sum('jumlah_item') }} Unit</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tanggal Perolehan</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asets as $index => $aset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aset->kode_barang }}</td>
                <td style="text-align: left;">{{ $aset->nama_barang }} ({{ $aset->jumlah_item }} Unit)</td>
                <td>{{ $aset->max_tanggal_perolehan ? \Carbon\Carbon::parse($aset->max_tanggal_perolehan)->format('d F Y') : '-' }}</td>
                <td style="text-transform: capitalize;">{{ $aset->status_label }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada aset terdaftar di ruangan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
