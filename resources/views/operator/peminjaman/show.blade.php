@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('operator.peminjaman.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Peminjaman & Serah Terima') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Main Info Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-8 pb-8 border-b border-slate-100 gap-6">
                        <div class="flex items-center gap-5">
                            <div class="h-16 w-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-2xl shadow-sm border border-indigo-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $peminjaman->asetBmn->nama_barang }}</h3>
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-sm font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">{{ $peminjaman->asetBmn->kode_barang }}</span>
                                    <span class="text-sm font-medium text-slate-400">Aset BMN</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex flex-col items-end">
                            <span class="block text-sm font-bold text-slate-400 mb-2">Status Peminjaman</span>
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
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Main Content Layout -->
                    <div class="max-w-4xl mx-auto mb-8">
                        
                        <!-- 4-Card Admin Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 items-stretch">
                            
                            <!-- 1. Informasi Peminjam -->
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Informasi Peminjam
                                </h4>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xl shrink-0">
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
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
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
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Keputusan TU -->
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Keputusan TU
                                </h4>
                                @if($peminjaman->status === 'pending')
                                    <div class="flex items-center gap-3 text-yellow-600 bg-white p-4 rounded-xl border border-slate-100">
                                        <svg class="w-5 h-5 animate-spin shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span class="text-sm font-bold">Menunggu persetujuan Kasubag.</span>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-lg shrink-0">
                                                {{ strtoupper(substr($peminjaman->approver->name ?? 'K', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs text-slate-500 font-medium mb-0.5">Diputuskan Oleh</p>
                                                <p class="text-sm font-bold text-slate-900">{{ $peminjaman->approver->name ?? 'Kasubag TU' }}</p>
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
                            <div class="bg-sky-50/30 p-6 rounded-2xl border border-sky-100 h-full flex flex-col">
                                <h4 class="text-sm font-extrabold text-sky-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Keperluan Peminjaman
                                </h4>
                                <div class="bg-white/50 p-4 rounded-xl border border-sky-50 grow">
                                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">{{ $peminjaman->keperluan }}</p>
                                </div>
                            </div>
                        </div>

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

                    <!-- Aksi Berdasarkan Status -->
                    @if($peminjaman->status === 'disetujui')
                        <div class="bg-blue-50/50 border border-blue-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-slate-900">Proses Serah Terima Aset</h4>
                            </div>
                            
                            <form action="{{ route('operator.peminjaman.serah_terima', $peminjaman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="foto_serah_terima" class="block text-sm font-bold text-slate-700 mb-2">Unggah Bukti Foto Serah Terima <span class="text-red-500">*</span></label>
                                    <div class="mt-1 w-full relative">
                                        <input type="file" id="foto_serah_terima" name="foto_serah_terima" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-3 file:px-6
                                            file:rounded-xl file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-blue-600 file:text-white
                                            hover:file:bg-blue-700 file:transition-colors file:cursor-pointer
                                            border border-slate-200 rounded-xl bg-white cursor-pointer" accept="image/*" required />
                                    </div>
                                    @error('foto_serah_terima')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-slate-500 mt-2 bg-white/50 px-3 py-2 rounded-lg border border-slate-100"><span class="font-bold text-slate-700">Catatan:</span> Pastikan foto terlihat jelas, menampilkan fisik barang saat diserahkan.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Apakah Anda yakin barang ini telah diserahkan kepada {{ $peminjaman->user->name }}?');" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Konfirmasi Serah Terima Barang
                                </button>
                            </form>
                        </div>
                    @elseif($peminjaman->status === 'dipinjam')
                        <div class="bg-emerald-50/50 border border-emerald-100 rounded-3xl p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-900">Proses Pengembalian Aset</h4>
                                </div>
                                
                                <!-- Kirim Reminder -->
                                <form action="{{ route('operator.peminjaman.reminder', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Kirim notifikasi pengingat ke Pegawai via WhatsApp?');" class="px-5 py-2.5 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl text-sm font-bold hover:bg-yellow-100 transition-colors duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 2.012c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.12-1.341a9.983 9.983 0 004.89 1.28h.004c5.504 0 9.985-4.48 9.985-9.984S17.516 2.012 12.01 2.012zM12.01 20.256h-.004a8.318 8.318 0 01-4.246-1.157l-.304-.18-3.155.827.842-3.077-.198-.314a8.312 8.312 0 01-1.272-4.42c.002-4.589 3.738-8.32 8.337-8.32 2.223 0 4.312.868 5.885 2.441a8.333 8.333 0 012.438 5.892c-.002 4.592-3.74 8.308-8.323 8.308zm4.568-6.223c-.25-.125-1.482-.733-1.712-.816-.23-.083-.398-.125-.565.125-.167.25-.648.816-.796.982-.148.167-.297.188-.547.063-1.077-.54-2.072-1.134-2.883-2.316-.21-.303.208-.284.697-.768.083-.083.167-.167.25-.25a1.135 1.135 0 00.167-.25c.083-.166.042-.312-.02-.437-.063-.125-.565-1.365-.774-1.87-.203-.49-.408-.424-.565-.432-.146-.007-.314-.007-.481-.007s-.44.062-.67.312c-.23.25-.878.858-.878 2.091 0 1.233.9 2.425 1.025 2.591.125.167 1.77 2.704 4.286 3.791.599.258 1.066.413 1.431.528.601.191 1.148.164 1.576.1.482-.073 1.482-.606 1.691-1.191.208-.585.208-1.085.147-1.191-.063-.105-.23-.167-.48-.292z"></path></svg>
                                        Pengingat Pegawai
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('operator.peminjaman.dikembalikan', $peminjaman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="foto_pengembalian" class="block text-sm font-bold text-slate-700 mb-2">Unggah Bukti Foto Barang Dikembalikan <span class="text-red-500">*</span></label>
                                    <div class="mt-1 w-full relative">
                                        <input type="file" id="foto_pengembalian" name="foto_pengembalian" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-3 file:px-6
                                            file:rounded-xl file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-emerald-600 file:text-white
                                            hover:file:bg-emerald-700 file:transition-colors file:cursor-pointer
                                            border border-slate-200 rounded-xl bg-white cursor-pointer" accept="image/*" required />
                                    </div>
                                    @error('foto_pengembalian')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-slate-500 mt-2 bg-white/50 px-3 py-2 rounded-lg border border-slate-100"><span class="font-bold text-slate-700">Catatan:</span> Pastikan foto terlihat jelas, menampilkan fisik barang yang telah dikembalikan ke ruangan Operator.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Apakah Anda yakin barang ini telah diterima kembali secara fisik beserta fotonya?');" class="w-full sm:w-auto px-8 py-3.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Konfirmasi Barang Dikembalikan
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
