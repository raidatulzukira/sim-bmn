@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            {{ __('Detail Persetujuan Peminjaman') }}
        </h2>
        <a href="{{ route('kasubag.persetujuan.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                <!-- Decorative element -->
                <div class="absolute top-0 right-0 -mt-16 -mr-16 text-indigo-50 opacity-50">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                </div>

                <div class="relative z-10">
                    <!-- Header Info -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-8 border-b border-slate-100 gap-4">
                        <div>
                            @php
                                $jenisCount = isset($batch) ? $batch->map(function($item) {
                                    return $item->asetBmn->nama_barang . '|' . $item->asetBmn->merk . '|' . $item->asetBmn->tipe;
                                })->unique()->count() : 1;
                            @endphp
                            @if($jenisCount > 1)
                                <div class="flex gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">No. Nota: {{ $peminjaman->batch_id }}</span>
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">Multi</span>
                                    <span class="px-2.5 py-0.5 bg-sky-100 text-sky-700 rounded-lg text-xs font-bold border border-sky-200">{{ isset($batch) ? $batch->count() : 1 }} Unit ({{ $jenisCount }} Jenis)</span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">Pengajuan Multi-Aset</h3>
                            @else
                                <div class="flex gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">No. Nota: {{ $peminjaman->batch_id }}</span>
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">{{ $peminjaman->asetBmn->kode_barang }}</span>
                                    <span class="px-2.5 py-0.5 bg-sky-100 text-sky-700 rounded-lg text-xs font-bold border border-sky-200">{{ isset($batch) ? $batch->count() : 1 }} Unit</span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">{{ $peminjaman->asetBmn->nama_barang }}</h3>
                            @endif
                        </div>
                        <div class="text-left md:text-right">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Pengajuan</span>
                            @php
                                $color = match($peminjaman->status) {
                                    'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                    'disetujui' => 'bg-blue-50 border-blue-200 text-blue-700',
                                    'dipinjam' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                    'dikembalikan' => 'bg-slate-100 border-slate-300 text-slate-700',
                                    'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                    default => 'bg-slate-50 border-slate-200 text-slate-700'
                                };
                            @endphp
                            <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full border {{ $color }}">
                                {{ $peminjaman->status_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Main Content Layout -->
                    <div class="max-w-4xl mx-auto mb-8">
                        
                        <!-- 4-Card Admin Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 items-stretch">
                            
                            <!-- 1. Informasi Peminjam -->
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Informasi Peminjam
                                </h4>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl shrink-0">
                                        {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Nama Peminjam</p>
                                        <p class="text-base font-bold text-slate-900">{{ $peminjaman->user->name }}</p>
                                    </div>
                                </div>
                                <div class="mt-auto grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">NIP</p>
                                        <p class="text-sm font-bold text-slate-900">{{ $peminjaman->user->nip ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Kontak WhatsApp</p>
                                        <p class="text-sm font-bold text-slate-900">{{ $peminjaman->user->no_wa ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Detail Waktu -->
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Detail Waktu
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Pengajuan</p>
                                        <p class="text-sm font-bold text-slate-900 bg-white px-3 py-2 rounded-lg border border-slate-200 inline-block">{{ $peminjaman->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Rencana Pinjam - Kembali</p>
                                        <p class="text-sm font-bold text-slate-900 bg-white px-3 py-2 rounded-lg border border-slate-200 inline-block">
                                            {{ $peminjaman->estimasi_waktu_pinjam->format('d M Y') }} <span class="text-slate-400 mx-1">s/d</span> {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                                            @if($peminjaman->keterangan_terlambat)
                                                <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-wider align-middle">
                                                    Terlambat {{ $peminjaman->keterangan_terlambat }} Hari
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Keputusan TU -->
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Keputusan Anda
                                </h4>
                                @if($peminjaman->status === 'pending')
                                    <div class="flex items-center gap-3 text-yellow-600 bg-white p-4 rounded-xl border border-slate-100">
                                        <svg class="w-5 h-5 animate-spin shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span class="text-sm font-bold">Menunggu persetujuan Anda.</span>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg shrink-0">
                                                {{ strtoupper(substr($peminjaman->approver->name ?? 'K', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-0.5">Diputuskan Oleh</p>
                                                <p class="text-sm font-bold text-slate-900">{{ $peminjaman->approver->name ?? 'Anda (Kasubag TU)' }}</p>
                                            </div>
                                        </div>
                                        @if($peminjaman->status === 'ditolak')
                                            <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r-lg max-w-full">
                                                <p class="text-xs text-red-500 font-bold mb-1">Alasan Penolakan</p>
                                                <p class="text-sm font-medium text-red-700">{{ $peminjaman->catatan_penolakan }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- 4. Keperluan Peminjaman -->
                            <div class="bg-indigo-50/30 p-6 rounded-2xl border border-indigo-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Keperluan Peminjaman
                                </h4>
                                <div class="bg-white/50 p-4 rounded-xl border border-indigo-50 grow">
                                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">{{ $peminjaman->keperluan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Aset -->
                        @if(isset($batch) && $batch->count() > 0)
                            <div class="mt-8">
                                <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    Ringkasan Aset
                                </h4>
                                <div class="bg-white p-4 rounded-xl border border-slate-200">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @php
                                            $groupedAssets = $batch->groupBy(function($item) {
                                                return $item->asetBmn->nama_barang;
                                            });
                                        @endphp
                                        @foreach($groupedAssets as $namaBarang => $items)
                                            <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                                    {{ $items->count() }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">{{ $namaBarang }}</p>
                                                    <p class="text-xs font-medium text-slate-500">Unit Dipinjam</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Daftar Aset -->
                        @if(isset($batch) && $batch->count() > 0)
                            <div class="mt-8">
                                <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Daftar NUP Aset yang Dipinjam
                                </h4>
                                <div class="bg-white p-4 rounded-xl border border-slate-200 max-h-60 overflow-y-auto">
                                    <ul class="space-y-2">
                                        @foreach($batch as $item)
                                            <li class="flex flex-col sm:flex-row sm:items-center justify-between text-sm p-2 hover:bg-slate-50 rounded-lg transition-colors border border-transparent hover:border-slate-100">
                                                <div class="flex items-center gap-3">
                                                    <span class="font-mono text-slate-600 font-bold bg-slate-50 px-2 py-1 rounded border border-slate-200">{{ $item->asetBmn->nup }}</span>
                                                    <span class="text-slate-700 font-bold">{{ $item->asetBmn->nama_barang }}</span>
                                                    <span class="text-slate-500 font-medium hidden sm:inline-block">({{ $item->asetBmn->ruangan ? $item->asetBmn->ruangan->nama_ruangan : 'Gudang' }})</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- 2-Column Documentation Grid -->
                        @if($peminjaman->foto_serah_terima || $peminjaman->foto_pengembalian)
                            <div class="pt-2">
                                <h4 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-5 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Dokumentasi Fisik
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    
                                    @if($peminjaman->foto_serah_terima)
                                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                            <h5 class="text-sm font-extrabold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2 justify-center">
                                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                                Bukti Serah Terima
                                            </h5>
                                            <div class="bg-white p-3 rounded-xl border border-slate-100 mb-3 text-center">
                                                <img src="{{ asset('storage/' . $peminjaman->foto_serah_terima) }}" alt="Foto Serah Terima" class="w-full max-w-[200px] h-auto mx-auto rounded-lg shadow-sm">
                                            </div>
                                            <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl text-center text-xs font-bold border border-emerald-100">
                                                Diserahkan: {{ $peminjaman->tanggal_pinjam->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    @endif

                                    @if($peminjaman->foto_pengembalian)
                                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                            <h5 class="text-sm font-extrabold text-blue-600 uppercase tracking-wider mb-4 flex items-center gap-2 justify-center">
                                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                                Bukti Pengembalian
                                            </h5>
                                            <div class="bg-white p-3 rounded-xl border border-slate-100 mb-3 text-center">
                                                <img src="{{ asset('storage/' . $peminjaman->foto_pengembalian) }}" alt="Foto Pengembalian" class="w-full max-w-[200px] h-auto mx-auto rounded-lg shadow-sm">
                                            </div>
                                            <div class="bg-blue-50 text-blue-700 p-3 rounded-xl text-center text-xs font-bold border border-blue-100">
                                                Dikembalikan: {{ $peminjaman->tanggal_kembali_aktual->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Area -->
                    @if($peminjaman->status === 'pending')
                        <div class="border-t border-slate-100 pt-8 mt-8">
                            <h4 class="text-lg font-extrabold text-slate-900 mb-6 text-center">Tindakan Persetujuan</h4>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <!-- Form Setujui -->
                                <form action="{{ route('kasubag.persetujuan.approve', $peminjaman->id) }}" method="POST" class="w-full sm:w-64" onsubmit="return confirm('Anda yakin menyetujui pengajuan ini?');">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui Peminjaman
                                    </button>
                                </form>

                                <!-- Trigger Modal Tolak -->
                                <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')" class="w-full sm:w-64 flex justify-center items-center gap-2 py-3 px-4 rounded-xl shadow-sm border-2 border-red-100 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-all transform hover:-translate-y-0.5 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tolak Peminjaman
                                </button>
                            </div>

                            <!-- Modal Tolak -->
                            <div id="modal-tolak" class="hidden fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-tolak').classList.add('hidden')"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                                        <form action="{{ route('kasubag.persetujuan.reject', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            <div class="bg-white px-6 pt-6 pb-6">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-extrabold text-slate-900" id="modal-title">Tolak Peminjaman</h3>
                                                        <div class="mt-4">
                                                            <label for="catatan_penolakan" class="block text-sm font-bold text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                                            <textarea id="catatan_penolakan" name="catatan_penolakan" rows="4" class="mt-1 block w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm" placeholder="Jelaskan alasan mengapa pengajuan ini ditolak..." required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                    Konfirmasi Tolak
                                                </button>
                                                <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-6 py-2.5 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
