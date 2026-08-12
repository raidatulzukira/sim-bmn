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
    @if(!isset($is_pdf) || $is_pdf)
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 20%; text-align: center; vertical-align: middle;">
                <img src="{{ public_path('storage/images/LOGO KEMENTERIAN EPS [Converted].png') }}" style="width: 120px; height: auto;">
            </td>
            <td style="width: 80%; text-align: center; vertical-align: middle;">
                <div style="font-size: 14px; margin-bottom: 2px;">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA INDUSTRI</div>
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">BALAI DIKLAT INDUSTRI PADANG</div>
                <div style="font-size: 10px; margin-bottom: 2px;">Jl. Bungo Pasang, Tabing, Padang, Sumatera Barat – 25171 | Telp. (0751) 7051879, Fax. (0751) 447784</div>
                <div style="font-size: 10px;">Website: http://bdipadang.kemenperin.go.id | e-mail: bdipadang@kemenperin.go.id</div>
            </td>
        </tr>
    </table>
    <div style="border-bottom: 3px solid black; margin-bottom: 2px;"></div>
    <div style="border-bottom: 1px solid black; margin-bottom: 20px;"></div>
    @endif

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
                <th>Aset</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Selesai</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->jumlah_item }}x {{ $item->asetBmn->nama_barang }} ({{ $item->asetBmn->kode_barang }})</td>
                <td>{{ $item->tanggal_pengajuan ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!isset($is_pdf) || $is_pdf)
    <table style="width: 100%; border: none; margin-top: 40px; page-break-inside: avoid;">
        <tr>
            <td style="width: 70%; border: none;"></td>
            <td style="width: 30%; border: none; text-align: left;">
                <p style="margin-bottom: 60px;">Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Mengetahui,<br>Kasubag Tata Usaha</p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">Teguh arifianto</p>
                <p style="margin: 0;">NIP. 198412232012121002</p>
            </td>
        </tr>
    </table>
    @endif
</body>
</html>
