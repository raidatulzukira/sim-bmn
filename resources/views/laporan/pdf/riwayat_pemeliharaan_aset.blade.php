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
    @if(!isset($is_pdf) || $is_pdf)
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; border: none;">
        <tr>
            <td style="width: 20%; text-align: center; vertical-align: middle; border: none;">
                <img src="{{ public_path('storage/images/LOGO KEMENTERIAN EPS [Converted].png') }}" style="width: 120px; height: auto;">
            </td>
            <td style="width: 80%; text-align: center; vertical-align: middle; border: none;">
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
        <div class="title">LAPORAN RIWAYAT PEMELIHARAAN PER ASET</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="150px"><strong>Kode Barang</strong></td>
            <td>: {{ $aset->kode_barang }}</td>
        </tr>
        <tr>
            <td><strong>NUP</strong></td>
            <td>: {{ $aset->nup }}</td>
        </tr>
        <tr>
            <td><strong>Nama Barang</strong></td>
            <td>: {{ $aset->nama_barang }}</td>
        </tr>
        <tr>
            <td><strong>Merk/Tipe</strong></td>
            <td>: {{ $aset->merk ?: '-' }} / {{ $aset->tipe ?: '-' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Nota</th>
                <th>Tgl Pengajuan</th>
                <th>Jenis</th>
                <th>Lokasi</th>
                <th>Dilaporkan Oleh</th>
                <th>Deskripsi Kerusakan</th>
                <th>Status</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeliharaans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->batch_id }}</td>
                <td>{{ $item->tanggal_pengajuan ? \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') : '-' }}</td>
                <td style="text-transform: capitalize;">{{ $item->jenis }}</td>
                <td>{{ $item->lokasi ?? '-' }}</td>
                <td>{{ $item->pelapor ? $item->pelapor->name : 'Sistem' }}</td>
                <td>{{ $item->deskripsi_kerusakan ?? '-' }}</td>
                <td style="text-transform: capitalize;">{{ $item->status_label }}</td>
                <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!isset($is_pdf) || $is_pdf)
    <table style="width: 100%; border: none; margin-top: 40px;">
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
