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

    <div style="font-weight:bold; margin-bottom: 10px; font-size: 14px;">DAFTAR REKAM PEMINJAMAN:</div>

    @forelse($peminjamans as $index => $item)
        <div style="border: 1px solid #000; margin-bottom: 20px; padding: 10px;">
            <div style="font-weight: bold; border-bottom: 1px dashed #ccc; margin-bottom: 10px; padding-bottom: 5px;">Peminjaman #{{ $index + 1 }} - Status: {{ strtoupper($item->status) }}</div>
            
            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="width: 25%; padding: 3px 0;"><strong>Peminjam</strong></td>
                    <td style="width: 25%; padding: 3px 0;">: {{ $item->user ? $item->user->name : '-' }}</td>
                    <td style="width: 25%; padding: 3px 0;"><strong>Disetujui Oleh</strong></td>
                    <td style="width: 25%; padding: 3px 0;">: {{ $item->approver ? $item->approver->name : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Tgl Pinjam (Aktual)</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d F Y') : '-' }}</td>
                    <td style="padding: 3px 0;"><strong>Est. Waktu Pinjam</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->estimasi_waktu_pinjam ? \Carbon\Carbon::parse($item->estimasi_waktu_pinjam)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Rencana Kembali</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->tanggal_kembali_rencana ? \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d F Y') : '-' }}</td>
                    <td style="padding: 3px 0;"><strong>Kembali Aktual</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->tanggal_kembali_aktual ? \Carbon\Carbon::parse($item->tanggal_kembali_aktual)->format('d F Y') : '-' }}</td>
                </tr>
            </table>

            <div style="margin-bottom: 8px; margin-top: 10px;">
                <span style="display: inline-block; width: 150px; font-weight: bold;">Keperluan</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #ccc;">{{ $item->keperluan ?? '-' }}</div>
            </div>

            @if($item->catatan_penolakan)
            <div style="margin-bottom: 8px; margin-top: 10px;">
                <span style="display: inline-block; width: 150px; font-weight: bold;">Catatan Penolakan</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #e74c3c;">{{ $item->catatan_penolakan }}</div>
            </div>
            @endif

            @if($item->foto_serah_terima || $item->foto_pengembalian)
            <div style="margin-bottom: 8px; margin-top: 10px;">
                <table style="width: 100%; border: none;">
                    <tr>
                        @if($item->foto_serah_terima)
                        <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                            <strong>Foto Serah Terima:</strong><br/>
                            <div style="margin-top: 5px;">
                                <img src="{{ public_path('storage/' . $item->foto_serah_terima) }}" style="max-width: 200px; max-height: 150px; border: 1px solid #ccc; padding: 2px;" alt="Foto Serah Terima">
                            </div>
                        </td>
                        @endif
                        @if($item->foto_pengembalian)
                        <td style="width: 50%; border: none; padding: 0; vertical-align: top;">
                            <strong>Foto Pengembalian:</strong><br/>
                            <div style="margin-top: 5px;">
                                <img src="{{ public_path('storage/' . $item->foto_pengembalian) }}" style="max-width: 200px; max-height: 150px; border: 1px solid #ccc; padding: 2px;" alt="Foto Pengembalian">
                            </div>
                        </td>
                        @endif
                    </tr>
                </table>
            </div>
            @endif
        </div>
    @empty
        <div style="text-align: center; padding: 20px; border: 1px solid #ccc; color: #666;">
            Belum ada catatan peminjaman untuk aset ini.
        </div>
    @endforelse
</body>
</html>
