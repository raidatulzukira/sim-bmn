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
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">{{ $peminjaman->asetBmn->nama_barang }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-sm font-mono font-bold">{{ $peminjaman->asetBmn->kode_barang }}</span>
                                <span class="text-slate-500 text-sm">Kode Aset</span>
                            </div>
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
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Pegawai Info -->
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Pegawai
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                                        {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Nama Peminjam</p>
                                        <p class="text-base font-bold text-slate-900">{{ $peminjaman->user->name }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 pt-2">
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">NIP</p>
                                        <p class="text-sm font-bold text-slate-800">{{ $peminjaman->user->nip ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Kontak (WA)</p>
                                        <p class="text-sm font-bold text-slate-800">{{ $peminjaman->user->no_wa ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu Info -->
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Waktu
                            </h4>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-xs text-slate-500 font-medium mb-1">Tanggal Pengajuan</p>
                                    <p class="text-sm font-bold text-slate-900 bg-white px-3 py-2 rounded-lg border border-slate-200 inline-block">{{ $peminjaman->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-medium mb-1">Rencana Pinjam - Kembali</p>
                                    <div class="flex items-center gap-2 text-sm font-bold text-slate-900">
                                        <span class="bg-white px-3 py-2 rounded-lg border border-slate-200">{{ $peminjaman->estimasi_waktu_pinjam->format('d F Y') }}</span>
                                        <span class="text-slate-400">s/d</span>
                                        <span class="bg-white px-3 py-2 rounded-lg border border-slate-200">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="mb-8 bg-indigo-50/30 p-6 rounded-2xl border border-indigo-100">
                        <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Keperluan Peminjaman
                        </h4>
                        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">{{ $peminjaman->keperluan }}</p>
                    </div>

                    <!-- Dokumentasi -->
                    @if($peminjaman->foto_serah_terima || $peminjaman->foto_pengembalian)
                        <div class="mb-8">
                            <h4 class="text-sm font-extrabold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Dokumentasi Aset
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($peminjaman->foto_serah_terima)
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Bukti Serah Terima</h5>
                                        <img src="{{ asset('storage/' . $peminjaman->foto_serah_terima) }}" class="w-full h-48 object-cover rounded-lg shadow-sm border border-slate-200" alt="Bukti Serah Terima">
                                        <p class="mt-3 text-xs font-medium text-slate-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Diserahkan: {{ $peminjaman->tanggal_pinjam?->format('d F Y H:i') }}</p>
                                    </div>
                                @endif
                                @if($peminjaman->foto_pengembalian)
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Bukti Pengembalian</h5>
                                        <img src="{{ asset('storage/' . $peminjaman->foto_pengembalian) }}" class="w-full h-48 object-cover rounded-lg shadow-sm border border-slate-200" alt="Bukti Pengembalian">
                                        <p class="mt-3 text-xs font-medium text-slate-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Dikembalikan: {{ $peminjaman->tanggal_kembali_aktual?->format('d F Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

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
                    @else
                        <!-- Note/Status Block -->
                        @if($peminjaman->status === 'ditolak')
                            <div class="bg-red-50 border-l-4 border-red-500 p-5 mt-8 rounded-r-xl">
                                <h4 class="text-sm font-extrabold text-red-800 mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Catatan Penolakan Anda:
                                </h4>
                                <p class="text-sm text-red-700 font-medium">{{ $peminjaman->catatan_penolakan }}</p>
                            </div>
                        @else
                            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-5 mt-8 rounded-r-xl">
                                <h4 class="text-sm font-extrabold text-emerald-800 mb-1 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Disetujui
                                </h4>
                                <p class="text-sm text-emerald-700 font-medium ml-7">
                                    Pengajuan ini disetujui pada <span class="font-bold">{{ $peminjaman->updated_at->format('d F Y H:i') }}</span>.
                                </p>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
