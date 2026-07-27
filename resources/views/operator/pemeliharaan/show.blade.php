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
    <div class="py-10 bg-slate-50 min-h-screen">
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
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $pemeliharaan->jenis === 'rutin' ? 'bg-slate-50 border-slate-200 text-slate-700' : 'bg-pink-50 border-pink-200 text-pink-700' }}">
                                        Servis {{ ucfirst($pemeliharaan->jenis) }}
                                    </span>
                                </div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $pemeliharaan->asetBmn->nama_barang }}</h3>
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-sm font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">{{ $pemeliharaan->asetBmn->kode_barang }}</span>
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
                                {{ ucfirst($pemeliharaan->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8 mb-8">
                        <div>
                            <div class="flex items-center gap-2 mb-4 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Informasi Pengajuan</h4>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-5 space-y-4 border border-slate-100">
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 mb-1">Tanggal Pengajuan</span>
                                    <span class="block text-sm font-bold text-slate-900">{{ $pemeliharaan->tanggal_pengajuan->format('d F Y, H:i') }}</span>
                                </div>
                                @if($pemeliharaan->jenis === 'situasional')
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 mb-1">Dilaporkan Oleh</span>
                                    <span class="block text-sm font-bold text-slate-900">{{ $pemeliharaan->pelapor->name }}</span>
                                </div>
                                @endif
                                @if($pemeliharaan->tanggal_selesai)
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 mb-1">Tanggal Selesai</span>
                                    <span class="block text-sm font-bold text-slate-900">{{ $pemeliharaan->tanggal_selesai->format('d F Y, H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-2 mb-4 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h4 class="text-sm font-bold uppercase tracking-wider">Persetujuan TU</h4>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 h-[calc(100%-2rem)]">
                                @if($pemeliharaan->status === 'pending')
                                    <div class="flex items-center gap-3 text-yellow-600 mt-2">
                                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span class="text-sm font-bold">Menunggu persetujuan Kasubag TU.</span>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div>
                                            <span class="block text-xs font-bold text-slate-400 mb-1">Diputuskan Oleh</span>
                                            <span class="block text-sm font-bold text-slate-900">{{ $pemeliharaan->approver->name ?? '-' }}</span>
                                        </div>
                                        @if($pemeliharaan->status === 'ditolak')
                                            <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                                                <span class="block text-xs text-red-500 font-bold mb-1">Alasan Penolakan</span>
                                                <span class="block text-sm font-medium text-red-700">{{ $pemeliharaan->catatan_validasi }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-4 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <h4 class="text-sm font-bold uppercase tracking-wider">Catatan / Deskripsi Kerusakan</h4>
                        </div>
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 text-sm text-slate-700 whitespace-pre-wrap font-medium leading-relaxed">{{ $pemeliharaan->deskripsi_kerusakan ?? 'Tidak ada catatan.' }}</div>
                    </div>

                    @if($pemeliharaan->foto)
                        <div class="mb-8 pt-8 border-t border-slate-100">
                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Bukti Kerusakan
                            </h4>
                            <div class="bg-slate-50 p-2 rounded-2xl border border-slate-200 inline-block">
                                <img src="{{ asset('storage/' . $pemeliharaan->foto) }}" alt="Foto Kerusakan" class="w-full max-w-md h-auto rounded-xl shadow-sm">
                            </div>
                        </div>
                    @endif

                    <!-- AKSI OPERATOR -->
                    @if($pemeliharaan->status === 'disetujui')
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
                            
                            <form action="{{ route('operator.pemeliharaan.proses', $pemeliharaan->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Mulai proses servis aset ini?');" class="w-full sm:w-auto px-8 py-3.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Tandai Mulai Diproses (Servis)
                                </button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'proses')
                        <div class="bg-orange-50/50 border border-orange-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-orange-900">Selesaikan Pemeliharaan</h4>
                            </div>
                            <p class="text-sm text-orange-800 mb-6 bg-white/60 p-4 rounded-xl border border-orange-100 leading-relaxed">
                                Aset saat ini sedang berstatus <strong>Dalam Perbaikan</strong>. Jika teknisi telah selesai memperbaiki, silakan unggah Nota / Bukti Servis untuk menyelesaikan proses. 
                                <strong class="text-orange-900 block mt-1">Aset akan kembali berstatus "Tersedia".</strong>
                            </p>
                            
                            <form action="{{ route('operator.pemeliharaan.selesai', $pemeliharaan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="nota_teknisi" class="block text-sm font-bold text-slate-700 mb-2">Unggah Nota Teknisi / Bukti Perbaikan <span class="text-red-500">*</span></label>
                                    <div class="mt-1 w-full relative">
                                        <input type="file" id="nota_teknisi" name="nota_teknisi" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-3 file:px-6
                                            file:rounded-xl file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-orange-500 file:text-white
                                            hover:file:bg-orange-600 file:transition-colors file:cursor-pointer
                                            border border-slate-200 rounded-xl bg-white cursor-pointer" accept=".jpg,.jpeg,.png,.pdf" required />
                                    </div>
                                    @error('nota_teknisi')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-orange-600 mt-2 font-medium">Format yang diizinkan: JPG, PNG, PDF. Maksimal 5MB.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Anda yakin proses perbaikan aset ini telah selesai sepenuhnya?');" class="w-full sm:w-auto px-8 py-3.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Selesaikan Perbaikan
                                </button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'selesai' && $pemeliharaan->nota_teknisi)
                        <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200">
                            <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Hasil Perbaikan (Nota Teknisi)
                            </h4>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pemeliharaan->nota_teknisi) }}" target="_blank" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-slate-800 hover:bg-slate-700 transition-colors duration-200 gap-2">
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
            </div>
        </div>
    </div>
@endsection
