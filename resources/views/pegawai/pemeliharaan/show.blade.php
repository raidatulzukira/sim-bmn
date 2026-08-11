@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Laporan Kerusakan') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <!-- Header Banner -->
                <div class="relative h-24 bg-gradient-to-r from-sky-600/30 to-sky-700/50">
                    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
                </div>

                <div class="px-8 sm:px-12 pb-12 relative -mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8 border-b border-slate-100 pb-8">
                        <div class="flex items-end gap-5">
                            <div class="w-20 h-20 rounded-2xl bg-white text-sky-500 flex items-center justify-center shadow-lg border-4 border-white shrink-0">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <div class="flex gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">
                                        {{ $laporan_kerusakan->asetBmn ? $laporan_kerusakan->asetBmn->kode_barang : 'N/A' }}
                                    </span>
                                    <span class="px-2.5 py-0.5 bg-sky-50 text-sky-600 rounded-lg text-xs font-bold border border-sky-100 capitalize">{{ $laporan_kerusakan->jenis ?? 'Kerusakan' }}</span>
                                </div>
                                <h3 class="text-2xl font-extrabold text-slate-900">
                                    {{ $laporan_kerusakan->asetBmn ? $laporan_kerusakan->asetBmn->nama_barang : 'Sedang diidentifikasi oleh Operator' }}
                                </h3>
                            </div>
                        </div>
                        <div class="mb-2">
                            @php
                                $badge = match($laporan_kerusakan->status) {
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'disetujui' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'proses' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                    'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="px-4 py-1.5 inline-flex items-center gap-2 text-xs font-bold rounded-full border shadow-sm {{ $badge }} uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full {{ $laporan_kerusakan->status == 'pending' ? 'bg-amber-500 animate-pulse' : ($laporan_kerusakan->status == 'proses' ? 'bg-indigo-500 animate-pulse' : ($laporan_kerusakan->status == 'selesai' ? 'bg-emerald-500' : 'bg-slate-500')) }}"></span>
                                {{ $laporan_kerusakan->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column: Details -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Informasi Laporan -->
                            <div>
                                <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Informasi Laporan
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dilaporkan Oleh</span>
                                        <span class="block text-sm font-bold text-slate-900">{{ $laporan_kerusakan->pelapor->name ?? '-' }}</span>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</span>
                                        <span class="block text-sm font-bold text-slate-900">{{ $laporan_kerusakan->tanggal_pengajuan ? \Carbon\Carbon::parse($laporan_kerusakan->tanggal_pengajuan)->format('d F Y, H:i') : '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- DAFTAR ASET DALAM BATCH INI -->
                            <div>
                                <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Daftar Aset yang Dilaporkan ({{ count($batch) }} Unit)
                                </h4>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
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
                                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-800">{{ $items->first()->asetBmn ? $items->first()->asetBmn->nama_barang : 'Aset Belum Diidentifikasi' }}</p>
                                                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Kode: <span class="font-mono">{{ $kode }}</span></p>
                                                        </div>
                                                    </div>
                                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-lg border border-indigo-100">
                                                        {{ $items->count() }} Unit
                                                    </span>
                                                </div>
                                                <div class="pl-11 border-t border-slate-50 pt-3">
                                                    <p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Nomor Urut Pendaftaran (NUP)</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($items as $item)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-mono font-bold bg-slate-50 text-slate-700 border border-slate-200">
                                                                {{ $item->asetBmn ? $item->asetBmn->nup : '?' }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Validasi & Penyelesaian -->
                            @if($laporan_kerusakan->status !== 'pending')
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Status & Penyelesaian
                                    </h4>
                                    <div class="space-y-4">
                                        @if($laporan_kerusakan->catatan_validasi)
                                            <div class="{{ $laporan_kerusakan->status === 'ditolak' ? 'bg-rose-50 border-rose-200' : 'bg-slate-50 border-slate-200' }} p-4 rounded-2xl border">
                                                <div class="flex justify-between items-start mb-2">
                                                    <span class="block text-xs font-bold {{ $laporan_kerusakan->status === 'ditolak' ? 'text-rose-500' : 'text-slate-500' }} uppercase tracking-wider">Catatan Validasi</span>
                                                    @if($laporan_kerusakan->approver)
                                                        <span class="block text-xs font-medium text-slate-400">Oleh: {{ $laporan_kerusakan->approver->name }}</span>
                                                    @endif
                                                </div>
                                                <span class="block text-sm font-bold text-slate-900">{{ $laporan_kerusakan->catatan_validasi }}</span>
                                            </div>
                                        @endif

                                        @if($laporan_kerusakan->status === 'selesai')
                                            <div class="flex flex-col sm:flex-row gap-4 items-start">
                                                <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 w-full sm:w-auto shrink-0">
                                                    <span class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Diselesaikan Pada</span>
                                                    <span class="block text-sm font-bold text-slate-900">{{ $laporan_kerusakan->tanggal_selesai ? \Carbon\Carbon::parse($laporan_kerusakan->tanggal_selesai)->format('d F Y, H:i') : '-' }}</span>
                                                </div>
                                                @if(!empty($laporan_kerusakan->nota_teknisi))
                                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col justify-center w-full grow">
                                                        <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bukti Perbaikan</span>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach((array) $laporan_kerusakan->nota_teknisi as $index => $nota)
                                                                <a href="{{ asset('storage/' . $nota) }}" target="_blank" class="inline-flex items-center justify-center gap-1 px-2 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-bold hover:bg-slate-700 transition-colors shadow-sm">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                    File {{ $index + 1 }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>



                        <!-- Right Column (Foto & Daftar Aset) -->
                        <div class="space-y-6">
                            <!-- Foto Bukti Kerusakan -->
                            <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Bukti Kerusakan
                            </h4>
                            <div class="bg-white rounded-2xl border border-slate-200 p-2 shadow-sm">
                                @if($laporan_kerusakan->foto)
                                    <img src="{{ asset('storage/' . $laporan_kerusakan->foto) }}" alt="Foto Kerusakan" class="w-full h-auto rounded-xl object-cover hover:opacity-90 transition-opacity cursor-pointer">
                                @else
                                    <div class="w-full h-48 bg-slate-50 rounded-xl flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-medium">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Deskripsi Kerusakan -->
                        <div>
                            <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Deskripsi Kerusakan
                            </h4>
                            <div class="bg-sky-50/50 p-4 rounded-xl border border-sky-100 text-sm text-slate-800 leading-relaxed font-medium">
                                {{ $laporan_kerusakan->deskripsi_kerusakan }}
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
