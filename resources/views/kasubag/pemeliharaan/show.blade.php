@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Review Persetujuan Pemeliharaan') }}
        </h2>
        <a href="{{ route('kasubag.persetujuan_pemeliharaan.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen" x-data="{ showRejectModal: false }">
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
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $pemeliharaan->jenis === 'rutin' ? 'bg-slate-100 border-slate-200 text-slate-700' : 'bg-pink-50 border-pink-200 text-pink-700' }}">
                                    {{ ucfirst($pemeliharaan->jenis) }}
                                </span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">{{ $pemeliharaan->asetBmn->nama_barang }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-sm font-mono font-bold">{{ $pemeliharaan->asetBmn->kode_barang }}</span>
                                <span class="text-slate-500 text-sm">Kode Aset</span>
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Pengajuan</span>
                            @php
                                $color = match($pemeliharaan->status) {
                                    'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                    'disetujui' => 'bg-blue-50 border-blue-200 text-blue-700',
                                    'proses' => 'bg-orange-50 border-orange-200 text-orange-700',
                                    'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                    'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                    default => 'bg-slate-50 border-slate-200 text-slate-700'
                                };
                            @endphp
                            <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full border {{ $color }}">
                                {{ ucfirst($pemeliharaan->status) }}
                            </span>
                        </div>
                    </div>

                    @php $hasFoto = $pemeliharaan->foto ? true : false; @endphp
                    <!-- Main Grid Layout -->
                    <div class="grid grid-cols-1 {{ $hasFoto ? 'lg:grid-cols-2' : 'max-w-4xl mx-auto' }} gap-8 mb-8 items-start">
                        
                        @if($hasFoto)
                        <!-- KOLOM KIRI: Media & Dokumen -->
                        <div class="flex flex-col gap-6">
                            <!-- Foto Bukti Kerusakan -->
                            <div>
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Foto Bukti Kerusakan
                                </h4>
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 inline-block w-full text-center">
                                    <img src="{{ asset('storage/' . $pemeliharaan->foto) }}" alt="Foto Kerusakan" class="w-full max-w-[240px] h-auto mx-auto rounded-lg shadow-sm border border-slate-200">
                                </div>
                            </div>

                            <!-- Bukti Perbaikan (Nota Teknisi) -->
                            @if($pemeliharaan->status === 'selesai' && $pemeliharaan->nota_teknisi)
                                <div>
                                    <h4 class="text-sm font-extrabold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Hasil Perbaikan (Nota Teknisi)
                                    </h4>
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 inline-block w-full text-left">
                                        <a href="{{ asset('storage/' . $pemeliharaan->nota_teknisi) }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 transition-colors duration-200 gap-2">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat File Nota
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endif

                        <!-- KOLOM KANAN: Informasi & Deskripsi -->
                        <div class="flex flex-col gap-6 w-full">
                            
                            <div class="{{ $hasFoto ? 'flex flex-col gap-6' : 'grid grid-cols-1 md:grid-cols-2 gap-6 w-full' }}">
                                <!-- Informasi Pengajuan -->
                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 w-full h-fit">
                                    <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Informasi Pengajuan
                                    </h4>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                                                {{ strtoupper(substr($pemeliharaan->jenis === 'situasional' ? $pemeliharaan->pelapor->name : 'Op', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium">Pelapor / Pengaju</p>
                                                <p class="text-base font-bold text-slate-900">{{ $pemeliharaan->jenis === 'situasional' ? $pemeliharaan->pelapor->name : 'Operator (Sistem Rutin)' }}</p>
                                            </div>
                                        </div>
                                        <div class="pt-2 flex flex-wrap gap-4">
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Pengajuan</p>
                                                <p class="text-sm font-bold text-slate-900 bg-white px-3 py-2 rounded-lg border border-slate-200 inline-block">{{ $pemeliharaan->tanggal_pengajuan->format('d F Y, H:i') }}</p>
                                            </div>
                                            @if($pemeliharaan->tanggal_selesai)
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Selesai Perbaikan</p>
                                                <p class="text-sm font-bold text-emerald-700 bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-200 inline-block">{{ $pemeliharaan->tanggal_selesai->format('d F Y, H:i') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Keputusan TU -->
                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 w-full h-fit">
                                    <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Keputusan TU
                                    </h4>
                                    @if($pemeliharaan->status === 'pending')
                                        <div class="flex items-center gap-3 text-yellow-600 bg-white p-4 rounded-xl border border-slate-100">
                                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <span class="text-sm font-bold pr-4">Menunggu persetujuan Anda.</span>
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg">
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

                            @if(!$hasFoto && $pemeliharaan->status === 'selesai' && $pemeliharaan->nota_teknisi)
                            <!-- Bukti Perbaikan (Nota Teknisi) untuk layout tanpa foto -->
                            <div class="bg-emerald-50/30 p-5 rounded-2xl border border-emerald-100 w-full h-fit">
                                <h4 class="text-sm font-extrabold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Hasil Perbaikan (Nota Teknisi)
                                </h4>
                                <div class="bg-white p-4 rounded-xl border border-emerald-100 inline-block w-full text-left">
                                    <a href="{{ asset('storage/' . $pemeliharaan->nota_teknisi) }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 transition-colors duration-200 gap-2">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat File Nota
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Catatan / Deskripsi Kerusakan -->
                            <div class="bg-indigo-50/30 p-5 rounded-2xl border border-indigo-100 w-full h-fit">
                                <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Catatan / Deskripsi Kerusakan
                                </h4>
                                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">{{ $pemeliharaan->deskripsi_kerusakan ?? 'Tidak ada catatan.' }}</p>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Action Area -->
                    @if($pemeliharaan->status === 'pending')
                        <div class="border-t border-slate-100 pt-8 mt-8">
                            <h4 class="text-lg font-extrabold text-slate-900 mb-6 text-center">Tindakan Persetujuan</h4>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <!-- Form Setujui -->
                                <form action="{{ route('kasubag.persetujuan_pemeliharaan.approve', $pemeliharaan->id) }}" method="POST" class="w-full sm:w-64" onsubmit="return confirm('Anda yakin menyetujui pengajuan pemeliharaan ini?');">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui Pemeliharaan
                                    </button>
                                </form>

                                <!-- Trigger Modal Tolak -->
                                <button type="button" @click="showRejectModal = true" class="w-full sm:w-64 flex justify-center items-center gap-2 py-3 px-4 rounded-xl shadow-sm border-2 border-red-100 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-all transform hover:-translate-y-0.5 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tolak Pengajuan
                                </button>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- REJECT MODAL (AlpineJS) -->
        @if($pemeliharaan->status === 'pending')
            <div x-show="showRejectModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showRejectModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <form action="{{ route('kasubag.persetujuan_pemeliharaan.reject', $pemeliharaan->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-6 pt-6 pb-6">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-extrabold text-slate-900" id="modal-title">Tolak Pengajuan Pemeliharaan</h3>
                                        <div class="mt-4">
                                            <p class="text-sm font-medium text-slate-500 mb-3">Anda wajib memberikan alasan penolakan agar diketahui oleh pengaju/pelapor.</p>
                                            <label for="catatan_validasi" class="block text-sm font-bold text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                            <textarea id="catatan_validasi" name="catatan_validasi" rows="4" class="mt-1 block w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm" placeholder="Tulis alasan penolakan di sini..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                    Konfirmasi Tolak
                                </button>
                                <button type="button" @click="showRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-6 py-2.5 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
