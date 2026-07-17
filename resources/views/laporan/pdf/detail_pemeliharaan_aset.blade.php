<!DOCTYPE html>
<html>
<head>
    <title>Detail Pemeliharaan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; border: none; }
        .content-box { border: 1px solid #000; margin-bottom: 20px; padding: 10px; }
        .box-title { font-weight: bold; border-bottom: 1px dashed #ccc; margin-bottom: 10px; padding-bottom: 5px; }
        .detail-row { margin-bottom: 8px; }
        .detail-label { display: inline-block; width: 150px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN DETAIL PEMELIHARAAN PER ASET</div>
        <div>SIM-BMN (Sistem Informasi Manajemen Barang Milik Negara)</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="20%"><strong>Kode Barang</strong></td>
            <td width="30%">: {{ $aset->kode_barang }}</td>
            <td width="20%"><strong>Tahun Perolehan</strong></td>
            <td width="30%">: {{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('Y') : '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Barang</strong></td>
            <td>: {{ $aset->nama_barang }}</td>
            <td><strong>Nilai Perolehan</strong></td>
            <td>: Rp {{ number_format($aset->nilai_perolehan_pertama, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Merk/Tipe</strong></td>
            <td>: {{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</td>
            <td><strong>Lokasi Ruangan</strong></td>
            <td>: {{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}</td>
        </tr>
    </table>

    <div style="font-weight:bold; margin-bottom: 10px; font-size: 14px;">DAFTAR REKAM PEMELIHARAAN:</div>

    @forelse($pemeliharaans as $index => $item)
        <div class="content-box">
            <div class="box-title">Pemeliharaan #{{ $index + 1 }} - Status: {{ strtoupper($item->status) }}</div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Pengajuan</span>: {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d F Y') }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Jenis Pemeliharaan</span>: <span style="text-transform: capitalize;">{{ $item->jenis }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Deskripsi Kerusakan</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #ccc;">{{ $item->deskripsi_kerusakan ?? '-' }}</div>
            </div>
            @if($item->catatan_teknisi)
            <div class="detail-row" style="margin-top: 10px;">
                <span class="detail-label">Catatan Teknisi/Operator</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #28a745;">{{ $item->catatan_teknisi }}</div>
            </div>
            @endif
            <div class="detail-row" style="margin-top: 10px;">
                <span class="detail-label">Biaya Perbaikan</span>: Rp {{ number_format($item->biaya ?? 0, 0, ',', '.') }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Selesai</span>: {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') : '-' }}
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 20px; border: 1px solid #ccc; color: #666;">
            Belum ada catatan pemeliharaan untuk aset ini.
        </div>
    @endforelse

</body>
</html>
