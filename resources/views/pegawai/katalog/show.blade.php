@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('pegawai.katalog_aset.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Aset BMN') }}
            </h2>
        </div>
        @if($stok_tersedia > 0)
            <div>
                <a href="{{ route('pegawai.peminjaman.create', ['aset_id' => $katalog_aset->id]) }}" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:-rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Ajukan Peminjaman
                </a>
            </div>
        @endif
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 relative group">
                <!-- Decorative Top Background -->
                <div class="h-32 w-full bg-gradient-to-r from-sky-100 via-sky-50 to-amber-50 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>
                </div>

                <div class="px-8 sm:px-12 pb-12 relative -mt-16">
                    <!-- Icon / Header Section -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-slate-100 pb-8 mb-8">
                        <div class="flex items-end gap-6">
                            <div class="h-28 w-28 rounded-3xl bg-white text-sky-500 flex items-center justify-center shadow-lg border-4 border-white group-hover:scale-105 transition-transform duration-500 z-10">
                                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div class="mb-2">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200 shadow-sm">{{ $katalog_aset->kode_barang }}</span>
                                    <span class="px-3 py-1 bg-sky-50 text-sky-600 rounded-lg text-xs font-bold border border-sky-100">{{ $katalog_aset->jenis_bmn }}</span>
                                </div>
                                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900">{{ $katalog_aset->nama_barang }}</h3>
                            </div>
                        </div>
                        <div class="mb-2 md:mb-4 flex flex-col gap-1 items-end">
                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-slate-100 text-slate-700">Total: {{ $total_stok }}</span>
                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-green-50 text-green-700">Tersedia: {{ $stok_tersedia }}</span>
                            @if($stok_dipinjam > 0)
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-indigo-50 text-indigo-700">Dipinjam: {{ $stok_dipinjam }}</span>
                            @endif
                            @if($stok_menunggu_persetujuan > 0)
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-amber-50 text-amber-700">Menunggu Persetujuan: {{ $stok_menunggu_persetujuan }}</span>
                            @endif
                            @if($stok_menunggu_serah_terima > 0)
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-sky-50 text-sky-700">Menunggu Serah Terima: {{ $stok_menunggu_serah_terima }}</span>
                            @endif
                            @if($stok_menunggu_servis > 0)
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-orange-50 text-orange-700">Menunggu Servis: {{ $stok_menunggu_servis }}</span>
                            @endif
                            @if($stok_servis > 0)
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-50 text-red-700">Servis: {{ $stok_servis }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informasi Utama -->
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Spesifikasi
                            </h4>
                            <ul class="space-y-5">
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                    </div>
                                    <div class="w-full">
                                        <span class="block text-sm font-bold text-slate-400 mb-1.5">Nomor Urut Pendaftaran (NUP) yang Terdaftar</span>
                                        <div class="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto pr-1">
                                            @forelse($semua_nup as $n)
                                                @php
                                                    $bg = match($n->status) {
                                                        'tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                        'dipinjam' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                        'servis' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                        'menunggu_persetujuan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                        'menunggu_serah_terima' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                        'menunggu_servis' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                                                    };
                                                @endphp
                                                <span class="px-2 py-0.5 text-xs font-bold font-mono rounded border {{ $bg }}" title="{{ $n->status_label }}">
                                                    {{ $n->nup }}
                                                </span>
                                            @empty
                                                <span class="text-sm font-medium text-slate-500">-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Merk / Tipe</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $katalog_aset->merk ?? '-' }} {{ $katalog_aset->tipe ? ' / ' . $katalog_aset->tipe : '' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Nama (Alias)</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $katalog_aset->nama ?? '-' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Jenis BMN</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $katalog_aset->jenis_bmn }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Lokasi Per NUP -->
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Daftar Lokasi Ruangan per NUP
                            </h4>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 max-h-[400px] overflow-y-auto">
                                <ul class="space-y-3">
                                    @forelse($semua_nup as $n)
                                        <li class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl shadow-sm hover:border-sky-200 transition-colors">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-700 font-bold font-mono text-sm border border-slate-200 shadow-inner">
                                                    {{ $n->nup }}
                                                </div>
                                                <span class="text-sm font-bold text-slate-700">
                                                    {{ $n->ruangan ? $n->ruangan->nama_ruangan : 'Belum ditempatkan' }}
                                                </span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm text-slate-500 text-center py-4 font-medium">Data NUP tidak tersedia</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
@endsection
