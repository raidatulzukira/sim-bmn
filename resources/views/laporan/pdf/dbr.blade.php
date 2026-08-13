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
            <td>: {{ $asets->count() }} Unit</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>NUP</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asets as $index => $aset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aset->kode_barang }}</td>
                <td>{{ $aset->nup }}</td>
                <td style="text-align: left;">{{ $aset->nama_barang }}</td>
                <td style="text-transform: capitalize;">{{ $aset->status_label }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada aset terdaftar di ruangan ini.</td>
            </tr>
            @endforelse
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
