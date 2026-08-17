@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('operator.pemeliharaan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Eksekusi Pemeliharaan Aset') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-8 pb-8 border-b border-slate-100 gap-6">
                        <div class="flex items-center gap-5">
                            <div class="h-16 w-16 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-2xl shadow-sm border border-sky-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="px-3 py-1 text-xs font-bold font-mono rounded-full border bg-slate-50 border-slate-200 text-slate-700">No. Nota: {{ $pemeliharaan->batch_id }}</span>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $pemeliharaan->jenis === 'rutin' ? 'bg-slate-50 border-slate-200 text-slate-700' : 'bg-pink-50 border-pink-200 text-pink-700' }}">
                                        Servis {{ ucfirst($pemeliharaan->jenis) }}
                                    </span>
                                </div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $pemeliharaan->asetBmn ? $pemeliharaan->asetBmn->nama_barang : 'Aset Belum Diidentifikasi' }}</h3>
                                <div class="flex items-center gap-3 mt-2">
                                    @if($batch->count() > 1)
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold text-sky-700 bg-sky-100 rounded-full border border-sky-200">
                                            Total: {{ $batch->count() }} Unit
                                        </span>
                                    @else
                                        <span class="font-mono text-sm font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">{{ $pemeliharaan->asetBmn ? $pemeliharaan->asetBmn->kode_barang : 'N/A' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex flex-col items-end">
                            <span class="block text-sm font-bold text-slate-400 mb-2">Status Servis</span>
                            @php
                                $color = match($pemeliharaan->status) {
                                    'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                    'disetujui' => 'bg-sky-50 border-sky-200 text-sky-700',
                                    'proses' => 'bg-orange-50 border-orange-200 text-orange-700',
                                    'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                    'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                    default => 'bg-slate-50 border-slate-200 text-slate-700'
                                };
                            @endphp
                            <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full border {{ $color }}">
                                {{ $pemeliharaan->status_label }}
                            </span>
                        </div>
                    </div>

                    @php $hasFoto = $pemeliharaan->foto ? true : false; @endphp
                    <!-- Main Grid Layout -->
                    <div class="grid grid-cols-1 {{ $pemeliharaan->jenis === 'situasional' ? 'lg:grid-cols-2' : '' }} gap-8 mb-8 items-start">
                        
                        <!-- KOLOM KIRI: Media, Dokumen & Deskripsi -->
                        <div class="flex flex-col gap-6 w-full">
                            
                            @if($pemeliharaan->jenis === 'situasional')
                            @if($hasFoto)
                            <!-- Foto Bukti Kerusakan -->
                            <div>
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Foto Bukti Kerusakan
                                </h4>
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 inline-block w-full text-center">
                                    <img src="{{ asset('storage/' . $pemeliharaan->foto) }}" alt="Foto Kerusakan" class="w-full max-w-[240px] h-auto mx-auto rounded-lg shadow-sm border border-slate-200">
                                </div>
                            </div>
                            @endif

                            <!-- Lokasi Kerusakan -->
                            <div class="mb-6">
                                <h4 class="text-sm font-extrabold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Lokasi Kerusakan
                                </h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 w-full text-left font-medium text-sm text-slate-700">
                                    {{ $pemeliharaan->lokasi ?? '-' }}
                                </div>
                            </div>
                            @endif

                            <!-- Deskripsi Kerusakan / Tindakan -->
                            <div>
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Deskripsi Kerusakan / Tindakan
                                </h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 w-full text-left">
                                    @php
                                        $uniqueDescriptions = $batch->pluck('deskripsi_kerusakan')->filter()->unique();
                                    @endphp
                                    @if($uniqueDescriptions->count() > 0)
                                        <ul class="list-disc list-inside text-sm font-medium text-slate-700 space-y-2">
                                            @foreach($uniqueDescriptions as $desc)
                                                <li>{{ $desc }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-sm font-medium text-slate-500 italic">Tidak ada deskripsi khusus yang diberikan.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Bukti Perbaikan (Nota Teknisi) -->
                            @if($pemeliharaan->status === 'selesai' && !empty($pemeliharaan->nota_teknisi))
                                <div>
                                    <h4 class="text-sm font-extrabold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Hasil Perbaikan (Nota Teknisi)
                                    </h4>
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 w-full text-left">
                                        <div class="flex flex-wrap gap-3">
                                            @foreach((array) $pemeliharaan->nota_teknisi as $index => $nota)
                                                <a href="{{ asset('storage/' . $nota) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold rounded-xl shadow-sm text-white bg-slate-800 hover:bg-slate-700 transition-colors duration-200 gap-2">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat File {{ $index + 1 }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- KOLOM KANAN: Informasi & Deskripsi -->
                        <div class="flex flex-col gap-6 w-full">
                            
                            <div class="flex flex-col gap-6">
                                <!-- Informasi Pengajuan -->
                                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 w-full h-fit">
                                    <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Informasi Pengajuan
                                    </h4>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xl">
                                                {{ strtoupper(substr($pemeliharaan->jenis === 'situasional' && $pemeliharaan->pelapor ? $pemeliharaan->pelapor->name : 'Op', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium">Pelapor / Pengaju</p>
                                                <p class="text-base font-bold text-slate-900">{{ $pemeliharaan->jenis === 'situasional' && $pemeliharaan->pelapor ? $pemeliharaan->pelapor->name : 'Admin (Sistem Rutin)' }}</p>
                                            </div>
                                        </div>
                                        <div class="pt-2 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Pengajuan</p>
                                                <p class="text-xs font-bold text-slate-900 bg-white px-3 py-2 rounded-lg border border-slate-200 block whitespace-nowrap">{{ $pemeliharaan->tanggal_pengajuan->format('d F Y, H:i') }}</p>
                                            </div>
                                            @if($pemeliharaan->tanggal_selesai)
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Selesai Perbaikan</p>
                                                <p class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-200 block whitespace-nowrap">{{ $pemeliharaan->tanggal_selesai->format('d F Y, H:i') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Keputusan TU -->
                                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 w-full h-fit">
                                    <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Keputusan TU
                                    </h4>
                                    @if($pemeliharaan->status === 'pending')
                                        <div class="flex items-center gap-3 text-yellow-600 bg-white p-4 rounded-xl border border-slate-100">
                                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            @if(is_null($pemeliharaan->aset_id))
                                                <span class="text-sm font-bold pr-4">Menunggu Anda menentukan Aset BMN terlebih dahulu.</span>
                                            @else
                                                <span class="text-sm font-bold pr-4">Menunggu persetujuan Kasubag TU.</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            <div class="bg-white p-3 rounded-xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-lg">
                                                    {{ strtoupper(substr($pemeliharaan->approver->name ?? 'X', 0, 1)) }}
                                                </div>
                                                <div class="pr-4">
                                                    <p class="text-xs text-slate-500 font-medium mb-0.5">Diputuskan Oleh</p>
                                                    <p class="text-sm font-bold text-slate-900">{{ $pemeliharaan->approver->name ?? '-' }}</p>
                                                </div>
                                            </div>
                                            @if($pemeliharaan->status === 'ditolak')
                                                <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r-lg max-w-full">
                                                    <p class="text-xs text-red-500 font-bold mb-1">Alasan Penolakan</p>
                                                    <p class="text-sm font-medium text-red-700">{{ $pemeliharaan->catatan_validasi }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- DAFTAR ASET DALAM BATCH INI -->
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 w-full h-fit">
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Daftar Aset yang Diservis
                                </h4>
                                <div class="space-y-3">
                                    @php
                                        $groupedBatch = $batch->groupBy(function($item) {
                                            return $item->asetBmn ? $item->asetBmn->kode_barang : 'unknown';
                                        });
                                    @endphp
                                    @foreach($groupedBatch as $kode => $items)
                                        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                            <div class="flex justify-between items-start mb-3">
                                                <div class="flex gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-800">{{ $items->first()->asetBmn ? $items->first()->asetBmn->nama_barang : 'Aset Belum Diidentifikasi' }}</p>
                                                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Kode: <span class="font-mono">{{ $kode }}</span></p>
                                                    </div>
                                                </div>
                                                <span class="px-2.5 py-1 bg-sky-50 text-sky-700 text-[10px] font-bold rounded-lg border border-sky-100">
                                                    {{ $items->count() }} Unit
                                                </span>
                                            </div>
                                            <div class="pl-11 border-t border-slate-50 pt-3">
                                                <p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Detail NUP</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($items as $item)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-mono font-bold bg-slate-50 text-slate-700 border border-slate-200 shrink-0 text-center">
                                                            NUP: {{ $item->asetBmn ? $item->asetBmn->nup : '?' }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>




                            
                        </div>
                    </div>

                    <!-- AKSI OPERATOR -->
                    @if($pemeliharaan->status === 'pending' && is_null($pemeliharaan->aset_id))
                        <div class="bg-indigo-50/50 border border-indigo-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-indigo-900">Tentukan Aset BMN</h4>
                            </div>
                            <p class="text-sm text-indigo-800 mb-6 bg-white/60 p-4 rounded-xl border border-indigo-100 leading-relaxed">
                                Laporan ini dibuat oleh pegawai tanpa identifikasi aset. Silakan tinjau ke lapangan atau lihat foto kerusakan untuk mengidentifikasi NUP aset. 
                                <strong class="text-indigo-900 block mt-1">Setelah Anda menentukan aset, notifikasi akan dikirim ke Kasubag TU untuk persetujuan.</strong>
                            </p>
                            
                            <form action="{{ route('operator.pemeliharaan.tentukan_aset', $pemeliharaan->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="bg-white p-5 rounded-2xl border border-slate-200">
                                    <label for="aset_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset BMN <span class="text-red-500">*</span></label>
                                    <select id="aset_id" name="aset_id" class="block w-full text-base border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required>
                                        <option value="">-- Pilih Aset BMN yang Dimaksud --</option>
                                        @foreach($asets as $aset)
                                            <option value="{{ $aset->id }}">
                                                {{ $aset->kode_barang }} - {{ $aset->nama_barang }} (NUP: {{ $aset->nup }}) - {{ $aset->status_label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aset_id')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" onclick="return confirm('Lanjutkan laporan ini ke Kasubag TU?');" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    Simpan & Teruskan ke Kasubag TU
                                </button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'disetujui')
                        <div class="bg-sky-50/50 border border-sky-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-slate-900">Mulai Tindakan Pemeliharaan</h4>
                            </div>
                            <p class="text-sm text-slate-600 mb-6 bg-white/60 p-4 rounded-xl border border-slate-100 leading-relaxed">
                                Pengajuan telah disetujui. Tekan tombol di bawah untuk memulai proses perbaikan. 
                                <strong class="text-sky-700 block mt-1">Status aset BMN ini akan otomatis diubah menjadi "Servis" di sistem master data.</strong>
                            </p>
                            
                            <form action="{{ route('operator.pemeliharaan.proses', $pemeliharaan->id) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <button type="submit" onclick="return confirm('Mulai proses servis aset ini?');" class="w-full sm:w-auto px-8 py-3.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    @if($batch->count() > 1)
                                        Tandai {{ $batch->count() }} Aset Mulai Diproses
                                    @else
                                        Tandai Mulai Diproses (Servis)
                                    @endif
                                </button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'proses')
                        <div class="bg-indigo-50/50 border border-indigo-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-indigo-900">Selesaikan Pemeliharaan</h4>
                            </div>
                            <p class="text-sm text-indigo-800 mb-6 bg-white/60 p-4 rounded-xl border border-indigo-100 leading-relaxed">
                                Aset saat ini sedang berstatus <strong>Dalam Perbaikan</strong>. Jika teknisi telah selesai memperbaiki, silakan unggah Nota / Bukti Servis untuk menyelesaikan proses. 
                                <strong class="text-indigo-900 block mt-1">Aset akan kembali berstatus "Tersedia".</strong>
                            </p>
                            
                            <form action="{{ route('operator.pemeliharaan.selesai', $pemeliharaan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="nota_teknisi" class="block text-sm font-bold text-slate-700 mb-2">Unggah Nota Teknisi / Bukti Perbaikan <span class="text-red-500">*</span></label>
                                    <div class="mt-1 w-full relative">
                                        <input type="file" id="nota_teknisi" name="nota_teknisi[]" multiple class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-3 file:px-6
                                            file:rounded-xl file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-sky-500 file:text-white
                                            hover:file:bg-sky-600 file:transition-colors file:cursor-pointer
                                            border border-slate-200 rounded-xl bg-white cursor-pointer" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>
                                    @error('nota_teknisi')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    @error('nota_teknisi.*')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-indigo-600 mt-2 font-medium">Format yang diizinkan: JPG, PNG, PDF. Maksimal 5MB.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Anda yakin proses perbaikan aset ini telah selesai sepenuhnya?');" class="w-full sm:w-auto px-8 py-3.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @if($batch->count() > 1)
                                        Selesaikan Perbaikan ({{ $batch->count() }} Aset)
                                    @else
                                        Selesaikan Perbaikan
                                    @endif
                                </button>
                            </form>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection

