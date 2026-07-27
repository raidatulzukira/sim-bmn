@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('operator.aset.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Aset BMN') }}
            </h2>
        </div>
        <div>
            <a href="{{ route('operator.aset.edit', $aset->id) }}" class="px-5 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-300 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Aset
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
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
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200 shadow-sm">{{ $aset->kode_barang }}</span>
                                    <span class="px-3 py-1 bg-sky-50 text-sky-600 rounded-lg text-xs font-bold border border-sky-100">{{ $aset->jenis_bmn }}</span>
                                </div>
                                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900">{{ $aset->nama_barang }}</h3>
                            </div>
                        </div>
                        <div class="mb-2 md:mb-4">
                            <span class="px-5 py-2 inline-flex text-sm font-bold rounded-full border shadow-sm
                                {{ $aset->status === 'tersedia' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : ($aset->status === 'dipinjam' ? 'bg-amber-50 border-amber-200 text-amber-700' : 'bg-rose-50 border-rose-200 text-rose-700') }}">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $aset->status === 'tersedia' ? 'bg-emerald-500 animate-pulse' : ($aset->status === 'dipinjam' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                    {{ $aset->status === 'dipinjam' ? 'Sedang Dipinjam' : ucfirst($aset->status) }}
                                </span>
                            </span>
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
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Nomor Urut Pendaftaran (NUP)</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->nup ?? '-' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Merk / Tipe</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->merk ?? '-' }} {{ $aset->tipe ? ' / ' . $aset->tipe : '' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Nama (Alias)</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->nama ?? '-' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Jenis BMN</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->jenis_bmn }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Lokasi, Perolehan & Servis -->
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Detail Lainnya
                            </h4>
                            <ul class="space-y-5">
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Lokasi Ruangan</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->ruangan ? $aset->ruangan->nama_ruangan : 'Belum ditempatkan' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Tanggal Perolehan</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d F Y') : '-' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Nilai Perolehan Pertama</span>
                                        <span class="block text-base font-medium text-slate-900 font-mono">Rp {{ number_format($aset->nilai_perolehan_pertama, 0, ',', '.') }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Pemeliharaan (Servis)</span>
                                        <span class="block text-base font-medium text-slate-900">
                                            Interval: {{ $aset->interval_servis_tahun ? $aset->interval_servis_tahun . ' Tahun' : '-' }} <br>
                                            Terakhir: {{ $aset->tanggal_servis_terakhir ? \Carbon\Carbon::parse($aset->tanggal_servis_terakhir)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Riwayat -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Riwayat Peminjaman -->
                <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800">Riwayat Peminjaman</h4>
                    </div>
                    
                    @if($aset->peminjaman->count() > 0)
                        <ul class="divide-y divide-slate-100">
                            @foreach($aset->peminjaman as $pinjam)
                                <li class="py-4 hover:bg-slate-50 transition-colors rounded-lg px-2 -mx-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">{{ $pinjam->user->name }}</p>
                                            <p class="text-sm text-slate-500 mt-1">{{ $pinjam->keperluan }}</p>
                                        </div>
                                        <div class="text-right flex flex-col items-end">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $pinjam->status == 'selesai' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-blue-50 text-blue-700 border-blue-200' }} capitalize mb-1">
                                                {{ $pinjam->status }}
                                            </span>
                                            <p class="text-xs text-slate-500 font-medium">{{ $pinjam->tanggal_pinjam?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="text-sm text-slate-500 font-medium">Belum ada riwayat peminjaman.</p>
                        </div>
                    @endif
                </div>

                <!-- Riwayat Pemeliharaan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800">Riwayat Pemeliharaan</h4>
                    </div>
                    
                    @if($aset->pemeliharaan->count() > 0)
                        <ul class="divide-y divide-slate-100">
                            @foreach($aset->pemeliharaan as $rawat)
                                <li class="py-4 hover:bg-slate-50 transition-colors rounded-lg px-2 -mx-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 capitalize">{{ $rawat->jenis }}</p>
                                            <p class="text-sm text-slate-500 mt-1">Oleh: {{ $rawat->pelapor->name ?? '-' }}</p>
                                        </div>
                                        <div class="text-right flex flex-col items-end">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $rawat->status == 'selesai' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-700 border-orange-200' }} capitalize mb-1">
                                                {{ $rawat->status }}
                                            </span>
                                            <p class="text-xs text-slate-500 font-medium">{{ $rawat->tanggal_pengajuan?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="text-sm text-slate-500 font-medium">Belum ada riwayat pemeliharaan.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
