@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
        <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        {{ __('Dashboard Pegawai') }}
    </h2>
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
                            Portal Pegawai BDI Padang
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-slate-600 text-lg max-w-xl mx-auto md:mx-0 leading-relaxed">
                            Akses cepat untuk meminjam barang dan melaporkan kendala aset negara dengan mudah.
                        </p>
                    </div>
                    <div class="flex-shrink-0 hidden md:block">
                        <img src="{{ asset('storage/images/illustration-dashboard.svg') }}" onerror="this.outerHTML='<div class=\'w-32 h-32 bg-white/60 rounded-2xl flex items-center justify-center border border-white/80 shadow-sm rotate-3\'><svg class=\'w-16 h-16 text-sky-500\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z\'></path></svg></div>'" alt="Welcome" class="w-48 h-auto drop-shadow-lg">
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Action 1 -->
                <a href="{{ route('pegawai.katalog_aset.index') }}" class="group bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-sky-200 transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-sky-100 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-sky-700 transition-colors">Katalog Aset</h4>
                    <p class="text-sm text-slate-500">Cari dan ajukan peminjaman aset BMN.</p>
                </a>

                <!-- Action 2 -->
                <a href="{{ route('pegawai.peminjaman.index') }}" class="group bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-amber-100 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-amber-600 transition-colors">Peminjaman Anda</h4>
                    <p class="text-sm text-slate-500">Pantau status pengajuan peminjaman barang.</p>
                </a>

                <!-- Action 3 -->
                <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="group bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-sky-200 transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-sky-100 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-sky-700 transition-colors">Lapor Kerusakan</h4>
                    <p class="text-sm text-slate-500">Laporkan kendala atau kerusakan pada aset.</p>
                </a>
            </div>

            <!-- Statistics Section -->
            <div class="mt-12">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Ringkasan Aktivitas Anda
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Stat 1 -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-1">Aset Aktif Dipinjam</div>
                            <div class="text-4xl font-black text-slate-800">{{ $jumlahDipinjam ?? 0 }}</div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-sky-50 flex items-center justify-center text-sky-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-1">Peminjaman Pending</div>
                            <div class="text-4xl font-black text-slate-800">{{ $jumlahPending ?? 0 }}</div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-1">Laporan Diproses</div>
                            <div class="text-4xl font-black text-slate-800">{{ $jumlahLaporanDiproses ?? 0 }}</div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-sky-50 flex items-center justify-center text-sky-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
