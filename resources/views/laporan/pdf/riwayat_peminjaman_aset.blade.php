<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman Aset</title>
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
        <div class="title">LAPORAN RIWAYAT PEMINJAMAN PER ASET</div>
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
                <th>Nama Peminjam</th>
                <th>Tgl Pengajuan</th>
                <th>Estimasi Pinjam</th>
                <th>Realisasi Kembali</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->estimasi_waktu_pinjam)->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_kembali_aktual ? \Carbon\Carbon::parse($item->tanggal_kembali_aktual)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->keperluan }}</td>
                <td style="text-transform: capitalize;">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
