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
            <td>: {{ $aset->merk ?: '-' }} / {{ $aset->tipe ?: '-' }}</td>
            <td><strong>Lokasi Ruangan</strong></td>
            <td>: {{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}</td>
        </tr>
    </table>

    <div style="font-weight:bold; margin-bottom: 10px; font-size: 14px;">DAFTAR REKAM PEMELIHARAAN:</div>

    @forelse($pemeliharaans as $index => $item)
        <div class="content-box" style="{{ !$loop->first ? 'page-break-before: always;' : '' }}">
            <div class="box-title">Pemeliharaan #{{ $index + 1 }} ({{ $item->jumlah_item }} Unit) - Status: {{ strtoupper($item->status_label) }}</div>
            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="width: 25%; padding: 3px 0;"><strong>Tanggal Pengajuan</strong></td>
                    <td style="width: 25%; padding: 3px 0;">: {{ $item->tanggal_pengajuan ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d F Y') : '-' }}</td>
                    <td style="width: 25%; padding: 3px 0;"><strong>Tanggal Selesai</strong></td>
                    <td style="width: 25%; padding: 3px 0;">: {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Jenis Pemeliharaan</strong></td>
                    <td style="padding: 3px 0; text-transform: capitalize;">: {{ $item->jenis }}</td>
                    <td style="padding: 3px 0;"><strong>Foto Bukti</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->foto ? 'Ada' : 'Tidak Ada' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;"><strong>Dilaporkan Oleh</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->pelapor ? $item->pelapor->name : 'Sistem' }}</td>
                    <td style="padding: 3px 0;"><strong>Disetujui Oleh</strong></td>
                    <td style="padding: 3px 0;">: {{ $item->approver ? $item->approver->name : '-' }}</td>
                </tr>
            </table>

            <div class="detail-row" style="margin-top: 10px;">
                <span class="detail-label">Deskripsi Kerusakan</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #ccc;">{{ $item->deskripsi_kerusakan ?? '-' }}</div>
            </div>

            @if($item->catatan_validasi)
            <div class="detail-row" style="margin-top: 10px;">
                <span class="detail-label">Catatan Validasi</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #f39c12;">{{ $item->catatan_validasi }}</div>
            </div>
            @endif

            @php
                $notas = (array) $item->nota_teknisi;
                $notaImages = [];
                $notaDocs = [];
                foreach ($notas as $nota) {
                    if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $nota)) {
                        $notaImages[] = $nota;
                    } else {
                        $notaDocs[] = $nota;
                    }
                }
            @endphp
            
            @if(count($notaDocs) > 0)
            <div class="detail-row" style="margin-top: 10px;">
                <span class="detail-label">Dokumen Nota Teknisi</span>: <br/>
                <div style="padding: 5px 10px; margin-top: 5px; border-left: 2px solid #28a745;">
                    {{ implode(', ', $notaDocs) }}
                </div>
            </div>
            @endif

            @if(count($notaImages) > 0 || $item->foto)
            <table style="width: 100%; margin-top: 15px;">
                <tr>
                    @if(count($notaImages) > 0)
                    <td style="width: 50%; vertical-align: top;">
                        <span class="detail-label">Nota Teknisi (Gambar)</span>: <br/>
                        <div style="margin-top: 5px;">
                            @foreach($notaImages as $img)
                            <img src="{{ public_path('storage/' . $img) }}" style="max-width: 150px; max-height: 150px; border: 1px solid #ccc; padding: 2px; margin-right: 5px; margin-bottom: 5px; display: inline-block;" alt="Nota Teknisi">
                            @endforeach
                        </div>
                    </td>
                    @endif

                    @if($item->foto)
                    <td style="width: 50%; vertical-align: top;">
                        <span class="detail-label">Lampiran Foto Kerusakan</span>: <br/>
                        <div style="margin-top: 5px;">
                            <img src="{{ public_path('storage/' . $item->foto) }}" style="max-width: 250px; max-height: 200px; border: 1px solid #ccc; padding: 2px;" alt="Foto Bukti">
                        </div>
                    </td>
                    @endif
                </tr>
            </table>
            @endif
        </div>
    @empty
        <div style="text-align: center; padding: 20px; border: 1px solid #ccc; color: #666;">
            Belum ada catatan pemeliharaan untuk aset ini.
        </div>
    @endforelse

</body>
</html>
