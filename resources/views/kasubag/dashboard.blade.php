@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Dashboard Executive') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Ringkasan persetujuan dan pengawasan BMN.</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-xs font-medium text-slate-500">Kasubag TU</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-sky-200 via-sky-100 to-amber-100 rounded-3xl p-8 sm:p-10 shadow-sm border border-white relative overflow-hidden">
                <!-- Subtle minimal accent -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-amber-200/40 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-sky-300/30 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 text-sky-800 text-sm font-semibold mb-4 shadow-sm border border-white/80">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                            </span>
                            Portal Eksekutif BDI Padang
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">Halo, Kasubag TU! 👋</h3>
                        <p class="text-slate-600 text-lg max-w-xl mx-auto md:mx-0 leading-relaxed">
                            Pantau dan setujui seluruh aktivitas peminjaman serta pemeliharaan Barang Milik Negara secara langsung untuk memastikan operasional kantor berjalan lancar.
                        </p>
                    </div>
                    <div class="shrink-0 bg-white/60 backdrop-blur-md border border-white/80 p-6 rounded-3xl text-center min-w-[160px] shadow-sm rotate-2 hover:rotate-0 transition-transform duration-300 mx-auto md:mx-0 mt-4 md:mt-0">
                        <p class="text-sky-800 text-xs font-bold uppercase tracking-wider mb-2">Total Pending</p>
                        <p class="text-5xl font-black text-amber-500 drop-shadow-sm">{{ $jumlahPending ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Approval Cards Section -->
            <div>
                <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Menunggu Persetujuan Anda
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card Peminjaman -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-sky-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            </div>
                            @if(($jumlahPeminjamanPending ?? 0) > 0)
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                                </span>
                            @endif
                        </div>
                        <h5 class="text-xl font-extrabold text-slate-800 mb-1">Peminjaman Aset</h5>
                        <p class="text-sm text-slate-500 mb-6">Pengajuan peminjaman barang oleh pegawai.</p>
                        <div class="flex items-end justify-between">
                            <div>
                                <span class="text-4xl font-extrabold text-slate-900">{{ $jumlahPeminjamanPending ?? 0 }}</span>
                                <span class="text-sm font-bold text-slate-400 ml-1">antrean</span>
                            </div>
                            <a href="{{ route('kasubag.persetujuan.index', ['tab' => 'pending']) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-sky-600 transition-colors shadow-md shadow-slate-200">
                                Tinjau Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Card Pemeliharaan -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            @if(($jumlahPemeliharaanPending ?? 0) > 0)
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                </span>
                            @endif
                        </div>
                        <h5 class="text-xl font-extrabold text-slate-800 mb-1">Pemeliharaan Aset</h5>
                        <p class="text-sm text-slate-500 mb-6">Laporan kerusakan dan perbaikan aset.</p>
                        <div class="flex items-end justify-between">
                            <div>
                                <span class="text-4xl font-extrabold text-slate-900">{{ $jumlahPemeliharaanPending ?? 0 }}</span>
                                <span class="text-sm font-bold text-slate-400 ml-1">antrean</span>
                            </div>
                            <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'pending']) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-rose-600 transition-colors shadow-md shadow-slate-200">
                                Tinjau Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
