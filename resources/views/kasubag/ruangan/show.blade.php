@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('kasubag.ruangan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Ruangan') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 relative group">
                <div class="h-32 w-full bg-gradient-to-r from-sky-100 via-sky-50 to-amber-50 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>
                </div>

                <div class="px-8 sm:px-12 pb-12 relative -mt-16">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-slate-100 pb-8 mb-8">
                        <div class="flex items-end gap-6">
                            <div class="h-28 w-28 rounded-3xl bg-white text-sky-500 flex items-center justify-center shadow-lg border-4 border-white group-hover:scale-105 transition-transform duration-500 z-10">
                                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <div class="mb-2">
                                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900">{{ $ruangan->nama_ruangan }}</h3>
                            </div>
                        </div>
                        <div class="mb-2 md:mb-4">
                            <span class="px-5 py-2 inline-flex items-center gap-2 text-sm font-bold rounded-full border shadow-sm bg-emerald-50 border-emerald-200 text-emerald-700">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                {{ $ruangan->asetBmn->count() }} Aset Terdaftar
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Informasi Lokasi
                            </h4>
                            <ul class="space-y-5">
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Lokasi / Gedung</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $ruangan->lokasi ?? '-' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Lantai</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $ruangan->lantai ?? '-' }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Detail Tambahan
                            </h4>
                            <ul class="space-y-5">
                                <li class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 text-slate-400 border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-slate-400 mb-0.5">Peruntukan / Keterangan</span>
                                        <span class="block text-base font-medium text-slate-900">{{ $ruangan->peruntukan ?? '-' }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Daftar Aset -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100 p-8">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800">Daftar Aset di Ruangan Ini</h4>
                </div>
                
                @if($ruangan->asetBmn->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Merk/Tipe</th>
                                    <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">NUP</th>
                                    <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-50">
                                @foreach($ruangan->asetBmn as $aset)
                                    <tr class="hover:bg-sky-50/50 transition-colors duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                            <a href="{{ route('kasubag.aset.show', $aset->id) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $aset->nama_barang }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm text-slate-500">{{ $aset->merk ?? '-' }} {{ $aset->tipe ? '/ ' . $aset->tipe : '' }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-slate-500 font-mono">{{ $aset->nup ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $badge_bg = match($aset->status) {
                                                    'tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'dipinjam' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                    'servis' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    'menunggu_persetujuan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'menunggu_serah_terima' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                    'menunggu_servis' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-1 inline-flex items-center text-xs font-bold rounded-md border {{ $badge_bg }}">
                                                {{ $aset->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-sm text-slate-500 font-medium">Belum ada aset di ruangan ini.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
