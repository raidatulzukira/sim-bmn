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
                <th>Dilaporkan Oleh</th>
                <th>Deskripsi Kerusakan</th>
                @if(!($isPdf ?? false))
                <th>Foto</th>
                @endif
                <th>Status</th>
                @if(!($isPdf ?? false))
                <th>Catatan Validasi</th>
                <th>Approved By</th>
                <th>Nota Teknisi</th>
                @endif
                <th>Tgl Pengajuan</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->jumlah_item }}x {{ $item->asetBmn->nama_barang }} ({{ $item->asetBmn->kode_barang }})</td>
                <td style="text-transform: capitalize;">{{ $item->jenis }}</td>
                <td>{{ $item->pelapor ? $item->pelapor->name : 'Sistem' }}</td>
                <td>{{ $item->aggregated_deskripsi ?? $item->deskripsi_kerusakan ?? '-' }}</td>
                @if(!($isPdf ?? false))
                <td>{{ $item->foto ? 'Ada' : 'Tidak' }}</td>
                @endif
                <td style="text-transform: capitalize;">{{ $item->status_label }}</td>
                @if(!($isPdf ?? false))
                <td>{{ $item->catatan_validasi ?? '-' }}</td>
                <td>{{ $item->approver ? $item->approver->name : '-' }}</td>
                <td>
                    @if(!empty($item->nota_teknisi))
                        {{ count((array)$item->nota_teknisi) }} Lampiran
                    @else
                        -
                    @endif
                </td>
                @endif
                <td>{{ $item->tanggal_pengajuan ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
