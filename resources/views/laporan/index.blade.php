@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-sky-600 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        </div>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Cetak Laporan') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter Section -->
            <div class="max-w-3xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            <h3 class="text-lg font-bold text-slate-800">Filter Laporan</h3>
                        </div>

                    <form method="GET" action="{{ route(auth()->user()->role === 'operator' ? 'operator.laporan.index' : 'kasubag.laporan.index') }}" id="formFilter">
                        <div class="mb-8">
                            <label for="jenis_laporan" class="block text-sm font-bold text-slate-700 mb-2">Pilih Jenis Laporan <span class="text-red-500">*</span></label>
                            <select id="jenis_laporan" name="jenis_laporan" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" required onchange="toggleFilters()">
                                <option value="" disabled {{ !isset($jenis) ? 'selected' : '' }}>-- Pilih Laporan --</option>
                                <option value="rekap_pemeliharaan" {{ (isset($jenis) && $jenis === 'rekap_pemeliharaan') ? 'selected' : '' }}>Laporan Rekapitulasi Pemeliharaan</option>
                                <option value="riwayat_pemeliharaan_aset" {{ (isset($jenis) && $jenis === 'riwayat_pemeliharaan_aset') ? 'selected' : '' }}>Laporan Riwayat Pemeliharaan per Aset</option>
                                <option value="detail_pemeliharaan_aset" {{ (isset($jenis) && $jenis === 'detail_pemeliharaan_aset') ? 'selected' : '' }}>Laporan Detail Pemeliharaan per Aset</option>
                                <option value="riwayat_peminjaman_aset" {{ (isset($jenis) && $jenis === 'riwayat_peminjaman_aset') ? 'selected' : '' }}>Laporan Riwayat Peminjaman per Aset</option>
                                <option value="dbr" {{ (isset($jenis) && $jenis === 'dbr') ? 'selected' : '' }}>Laporan Daftar Barang Ruangan (DBR)</option>
                            </select>
                        </div>

                        <!-- Filter Rentang Tanggal -->
                        <div id="filter_tanggal" class="mb-8 hidden bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Rentang Tanggal Pengajuan
                            </h4>
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="flex-1">
                                    <label for="tanggal_awal" class="block text-xs font-bold text-slate-500 mb-1">Tanggal Awal</label>
                                    <input type="date" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm bg-white" />
                                </div>
                                <div class="flex-1">
                                    <label for="tanggal_akhir" class="block text-xs font-bold text-slate-500 mb-1">Tanggal Akhir</label>
                                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm bg-white" />
                                </div>
                            </div>
                            <p class="text-xs font-medium text-slate-400 mt-3">* Biarkan kosong untuk menampilkan semua data tanpa batasan waktu.</p>
                        </div>

                        <!-- Filter Pilih Aset -->
                        <div id="filter_aset" class="mb-8 hidden bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <label for="aset_id" class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Pilih Aset BMN <span class="text-red-500">*</span>
                            </label>
                            <select id="kode_barang" name="kode_barang" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm bg-white">
                                <option value="" disabled {{ !request('kode_barang') ? 'selected' : '' }}>-- Pilih Aset --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->kode_barang }}" {{ request('kode_barang') == $aset->kode_barang ? 'selected' : '' }}>[{{ $aset->kode_barang }}] {{ $aset->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Pilih Ruangan -->
                        <div id="filter_ruangan" class="mb-8 hidden bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <label for="ruangan_id" class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Pilih Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select id="ruangan_id" name="ruangan_id" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm bg-white">
                                <option value="" disabled {{ !request('ruangan_id') ? 'selected' : '' }}>-- Pilih Ruangan --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-8 py-3 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-300 shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Tampilkan Preview Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- Preview Section -->
            @if(isset($previewData) && isset($jenis))
                <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 mt-8 animate-fade-in-up">
                    <div class="p-8 sm:p-10 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-sky-50/30">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Preview Laporan
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">Data ditampilkan sesuai filter. Gunakan tombol export untuk mengunduh laporan utuh.</p>
                        </div>
                        
                        <!-- Form untuk Export (Menggunakan route POST generate) -->
                        <form method="POST" action="{{ route(auth()->user()->role === 'operator' ? 'operator.laporan.generate' : 'kasubag.laporan.generate') }}" target="_blank" class="flex flex-wrap gap-3">
                            @csrf
                            <input type="hidden" name="jenis_laporan" value="{{ $jenis }}">
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            <input type="hidden" name="kode_barang" value="{{ request('kode_barang') }}">
                            <input type="hidden" name="ruangan_id" value="{{ request('ruangan_id') }}">

                            <button type="submit" name="format" value="excel" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all duration-300 shadow-sm flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export Excel
                            </button>
                            <button type="submit" name="format" value="pdf" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl text-sm font-bold hover:bg-rose-700 transition-all duration-300 shadow-sm flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export PDF
                            </button>
                        </form>
                    </div>

                    <div class="p-8 sm:p-10">
                        @if($jenis === 'rekap_pemeliharaan')
                            <!-- Preview Rekap Pemeliharaan -->
                            <div class="mb-6 text-center">
                                <h4 class="text-xl font-bold uppercase text-slate-800">REKAPITULASI PEMELIHARAAN ASET BMN</h4>
                                @if($previewData['start'] && $previewData['end'])
                                    <p class="text-slate-500 font-medium mt-1">Periode: {{ \Carbon\Carbon::parse($previewData['start'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($previewData['end'])->format('d/m/Y') }}</p>
                                @endif
                            </div>
                            
                            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">No</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Aset</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Jenis</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Dilaporkan Oleh</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap min-w-[200px]">Deskripsi Kerusakan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Foto</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap min-w-[200px]">Catatan Validasi</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Approved By</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap min-w-[150px]">Nota Teknisi</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Tgl Pengajuan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Tgl Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @forelse($previewData['pemeliharaans'] as $index => $item)
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-sm font-bold text-slate-800 whitespace-nowrap">
                                                    {{ $item->jumlah_item }}x {{ $item->asetBmn->nama_barang }}
                                                    <div class="text-xs font-mono text-slate-400 font-normal">{{ $item->asetBmn->kode_barang }}</div>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600 capitalize whitespace-nowrap">{{ $item->jenis }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->pelapor ? $item->pelapor->name : 'Sistem' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $item->aggregated_deskripsi ?? $item->deskripsi_kerusakan ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 text-center">
                                                    @if($item->foto)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Ada</span>
                                                    @else
                                                        <span class="text-slate-400 text-xs">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm font-bold capitalize whitespace-nowrap {{ $item->status === 'selesai' ? 'text-emerald-600' : 'text-slate-600' }}">{{ $item->status }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $item->catatan_validasi ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->approver ? $item->approver->name : '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">
                                                    @if(!empty($item->nota_teknisi))
                                                        {{ count((array)$item->nota_teknisi) }} Lampiran
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->tanggal_pengajuan ? $item->tanggal_pengajuan->format('d/m/Y') : '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="px-4 py-8 text-center text-slate-500">Tidak ada data untuk periode ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        @elseif($jenis === 'riwayat_pemeliharaan_aset')
                            <!-- Preview Riwayat Pemeliharaan per Aset -->
                            @if(isset($previewData['aset']))
                            <div class="mb-6">
                                <h4 class="text-xl font-bold uppercase text-slate-800 text-center mb-4">RIWAYAT PEMELIHARAAN ASET BMN</h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 inline-block">
                                    <table class="text-sm">
                                        <tr><td class="font-bold text-slate-500 pr-4">Nama Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->nama_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Kode Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->kode_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Merk/Tipe</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->merk ?: '-' }} / {{ $previewData['aset']->tipe ?: '-' }}</td></tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">No</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Tgl Pengajuan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Jenis</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Dilaporkan Oleh</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap min-w-[200px]">Deskripsi Kerusakan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase whitespace-nowrap">Tgl Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @forelse($previewData['pemeliharaans'] as $index => $item)
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->tanggal_pengajuan ? $item->tanggal_pengajuan->format('d/m/Y') : '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 capitalize whitespace-nowrap">{{ $item->jenis }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->pelapor ? $item->pelapor->name : 'Sistem' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $item->aggregated_deskripsi ?? $item->deskripsi_kerusakan ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm font-bold capitalize whitespace-nowrap {{ $item->status === 'selesai' ? 'text-emerald-600' : 'text-slate-600' }}">{{ $item->status }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada riwayat pemeliharaan untuk aset ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @endif

                        @elseif($jenis === 'detail_pemeliharaan_aset')
                            <!-- Preview Detail Pemeliharaan -->
                            @if(isset($previewData['aset']))
                            <div class="mb-6">
                                <h4 class="text-xl font-bold uppercase text-slate-800 text-center mb-4">DETAIL PEMELIHARAAN ASET BMN</h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 inline-block">
                                    <table class="text-sm">
                                        <tr><td class="font-bold text-slate-500 pr-4">Nama Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->nama_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Kode Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->kode_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Merk/Tipe</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->merk ?: '-' }} / {{ $previewData['aset']->tipe ?: '-' }}</td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="space-y-6">
                                @forelse($previewData['pemeliharaans'] as $item)
                                    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
                                        <div class="flex justify-between items-start mb-4 pb-3 border-b border-slate-100">
                                            <div>
                                                <span class="font-bold text-slate-800">{{ $item->tanggal_pengajuan->format('d F Y') }}</span>
                                                <span class="ml-2 px-2 py-0.5 text-xs font-bold rounded-md bg-slate-100 text-slate-600">{{ ucfirst($item->jenis) }}</span>
                                            </div>
                                            <div class="flex flex-col items-end gap-1">
                                                <span class="font-bold text-sm {{ $item->status === 'selesai' ? 'text-emerald-600' : 'text-slate-600' }}">{{ $item->status_label }}</span>
                                                <span class="text-xs text-slate-500">Selesai: {{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d F Y') : '-' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm mb-4">
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Dilaporkan Oleh:</span>
                                                <span class="text-slate-800">{{ $item->pelapor ? $item->pelapor->name : 'Sistem (Rutin)' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Disetujui Oleh:</span>
                                                <span class="text-slate-800">{{ $item->approver ? $item->approver->name : '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Foto Bukti:</span>
                                                @if($item->foto)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Ada</span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Deskripsi/Tindakan:</span>
                                                <p class="text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $item->aggregated_deskripsi ?? $item->deskripsi_kerusakan ?? '-' }}</p>
                                            </div>
                                            @if($item->catatan_validasi)
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Catatan Validasi/Persetujuan:</span>
                                                <p class="text-slate-800 bg-orange-50 p-3 rounded-lg border border-orange-100">{{ $item->catatan_validasi }}</p>
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
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Nota/Catatan Teknisi (Dokumen):</span>
                                                <p class="text-slate-800 bg-emerald-50 p-3 rounded-lg border border-emerald-100">
                                                    @foreach($notaDocs as $doc)
                                                        <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="text-emerald-700 underline">{{ basename($doc) }}</a><br>
                                                    @endforeach
                                                </p>
                                            </div>
                                        @endif
                                        </div>
                                        
                                        @if(count($notaImages) > 0 || $item->foto)
                                        <div class="mt-4 pt-4 border-t border-slate-100">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                @if(count($notaImages) > 0)
                                                <div>
                                                    <span class="block text-slate-500 font-bold mb-2 text-sm">Nota Teknisi (Gambar):</span>
                                                    <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 inline-block flex flex-wrap gap-2">
                                                        @foreach($notaImages as $img)
                                                        <img src="{{ asset('storage/' . $img) }}" alt="Nota Teknisi" class="max-w-full h-auto max-h-40 rounded-lg shadow-sm">
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($item->foto)
                                                <div>
                                                    <span class="block text-slate-500 font-bold mb-2 text-sm">Lampiran Foto:</span>
                                                    <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 inline-block">
                                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Bukti" class="max-w-full h-auto max-h-40 rounded-lg shadow-sm">
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-slate-500 border border-slate-200 rounded-xl bg-slate-50">Belum ada data pemeliharaan untuk aset ini.</div>
                                @endforelse
                            </div>
                            @endif

                        @elseif($jenis === 'riwayat_peminjaman_aset')
                            <!-- Preview Riwayat Peminjaman -->
                            @if(isset($previewData['aset']))
                            <div class="mb-6">
                                <h4 class="text-xl font-bold uppercase text-slate-800 text-center mb-4">RIWAYAT PEMINJAMAN ASET BMN</h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 inline-block">
                                    <table class="text-sm">
                                        <tr><td class="font-bold text-slate-500 pr-4">Nama Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->nama_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Kode Aset</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->kode_barang }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Merk/Tipe</td><td class="font-bold text-slate-800">: {{ $previewData['aset']->merk ?: '-' }} / {{ $previewData['aset']->tipe ?: '-' }}</td></tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                @forelse($previewData['peminjamans'] as $item)
                                    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
                                        <div class="flex justify-between items-start mb-4 pb-3 border-b border-slate-100">
                                            <div>
                                                <span class="font-bold text-slate-800 text-lg">Peminjaman oleh {{ $item->user->name }}</span>
                                            </div>
                                            <div class="flex flex-col items-end gap-1">
                                                <span class="font-bold text-sm px-3 py-1 rounded-full bg-slate-100 {{ $item->status === 'dikembalikan' ? 'text-emerald-600' : 'text-sky-600' }}">{{ strtoupper($item->status) }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm mb-4">
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Tgl Pinjam (Aktual):</span>
                                                <span class="text-slate-800">{{ $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d F Y') : '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Est. Waktu Pinjam:</span>
                                                <span class="text-slate-800">{{ $item->estimasi_waktu_pinjam ? $item->estimasi_waktu_pinjam->format('d F Y') : '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Rencana Kembali:</span>
                                                <span class="text-slate-800">{{ $item->tanggal_kembali_rencana ? $item->tanggal_kembali_rencana->format('d F Y') : '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-slate-500 font-bold mb-1">Kembali Aktual:</span>
                                                <span class="text-slate-800">{{ $item->tanggal_kembali_aktual ? $item->tanggal_kembali_aktual->format('d F Y') : '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <span class="block text-slate-500 font-bold mb-1 text-sm">Keperluan:</span>
                                            <p class="text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-100 text-sm">{{ $item->keperluan ?? '-' }}</p>
                                        </div>

                                        @if($item->catatan_penolakan)
                                        <div class="mb-4">
                                            <span class="block text-slate-500 font-bold mb-1 text-sm">Catatan Penolakan:</span>
                                            <p class="text-red-700 bg-red-50 p-3 rounded-lg border border-red-100 text-sm">{{ $item->catatan_penolakan }}</p>
                                        </div>
                                        @endif

                                        @if($item->foto_serah_terima || $item->foto_pengembalian)
                                        <div class="mt-4 pt-4 border-t border-slate-100">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                @if($item->foto_serah_terima)
                                                <div>
                                                    <span class="block text-slate-500 font-bold mb-2 text-sm">Foto Serah Terima:</span>
                                                    <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 inline-block">
                                                        <img src="{{ asset('storage/' . $item->foto_serah_terima) }}" alt="Foto Serah Terima" class="max-w-full h-auto max-h-40 rounded-lg shadow-sm">
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($item->foto_pengembalian)
                                                <div>
                                                    <span class="block text-slate-500 font-bold mb-2 text-sm">Foto Pengembalian:</span>
                                                    <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 inline-block">
                                                        <img src="{{ asset('storage/' . $item->foto_pengembalian) }}" alt="Foto Pengembalian" class="max-w-full h-auto max-h-40 rounded-lg shadow-sm">
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                        <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex justify-end">
                                            <span><strong>Disetujui oleh:</strong> {{ $item->approver ? $item->approver->name : '-' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-slate-500 border border-slate-200 rounded-xl bg-slate-50">Belum ada riwayat peminjaman untuk aset ini.</div>
                                @endforelse
                            </div>
                            @endif

                        @elseif($jenis === 'dbr')
                            <!-- Preview DBR -->
                            @if(isset($previewData['ruangan']))
                            <div class="mb-6">
                                <h4 class="text-xl font-bold uppercase text-slate-800 text-center mb-4">DAFTAR BARANG RUANGAN (DBR)</h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 inline-block">
                                    <table class="text-sm">
                                        <tr><td class="font-bold text-slate-500 pr-4">Ruangan</td><td class="font-bold text-slate-800">: {{ $previewData['ruangan']->nama_ruangan }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Keterangan</td><td class="font-bold text-slate-800">: {{ $previewData['ruangan']->keterangan ?? '-' }}</td></tr>
                                        <tr><td class="font-bold text-slate-500 pr-4">Jumlah</td><td class="font-bold text-slate-800">: {{ $previewData['asets']->sum('jumlah_item') }} Unit</td></tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Kode Aset</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Nama Aset</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Tanggal Perolehan</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Kondisi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @forelse($previewData['asets'] as $index => $item)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-sm font-mono text-slate-500">{{ $item->kode_barang }}</td>
                                                <td class="px-4 py-3 text-sm font-bold text-slate-800">{{ $item->nama_barang }} <span class="text-xs text-slate-500 font-normal">({{ $item->jumlah_item }} Unit)</span></td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $item->max_tanggal_perolehan ? \Carbon\Carbon::parse($item->max_tanggal_perolehan)->format('d F Y') : '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 capitalize">{{ $item->status }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">Tidak ada aset di ruangan ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @endif

                    </div>
                </div>
            @endif

        </div>
    </div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function toggleFilters() {
            const jenis = document.getElementById('jenis_laporan').value;
            const filterTanggal = document.getElementById('filter_tanggal');
            const filterAset = document.getElementById('filter_aset');
            const filterRuangan = document.getElementById('filter_ruangan');
            const asetInput = document.getElementById('kode_barang');
            const ruanganInput = document.getElementById('ruangan_id');

            // Reset visibilitas
            filterTanggal.classList.add('hidden');
            filterAset.classList.add('hidden');
            filterRuangan.classList.add('hidden');

            // Hapus required attribute terlebih dahulu
            asetInput.removeAttribute('required');
            ruanganInput.removeAttribute('required');

            if (jenis === 'rekap_pemeliharaan') {
                filterTanggal.classList.remove('hidden');
            } else if (jenis === 'riwayat_pemeliharaan_aset' || jenis === 'detail_pemeliharaan_aset' || jenis === 'riwayat_peminjaman_aset') {
                filterAset.classList.remove('hidden');
                asetInput.setAttribute('required', 'required');
            } else if (jenis === 'dbr') {
                filterRuangan.classList.remove('hidden');
                ruanganInput.setAttribute('required', 'required');
            }
        }
        
        // Panggil saat load untuk mengembalikan state jika ada query parameter
        window.addEventListener('DOMContentLoaded', toggleFilters);
    </script>
@endsection
