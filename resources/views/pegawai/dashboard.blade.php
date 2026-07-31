@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
        <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        {{ __('Dashboard Pegawai') }}
    </h2>
@endsection

@section('content')
<style>
    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-18px) rotate(3deg); }
    }
    @keyframes float-medium {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(-2deg); }
    }
    @keyframes pulse-ring {
        0% { transform: scale(1); opacity: 0.7; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes count-up {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes blob {
        0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    }

    .anim-slide-up { animation: slide-up 0.6s ease both; }
    .anim-d1 { animation-delay: 0.05s; }
    .anim-d2 { animation-delay: 0.15s; }
    .anim-d3 { animation-delay: 0.25s; }
    .anim-d4 { animation-delay: 0.35s; }
    .anim-d5 { animation-delay: 0.45s; }
    .anim-d6 { animation-delay: 0.55s; }

    .float-slow { animation: float-slow 6s ease-in-out infinite; }
    .float-medium { animation: float-medium 4.5s ease-in-out infinite; }

    .action-card {
        transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s ease;
    }
    .action-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -10px rgba(14, 165, 233, 0.18);
    }
    .action-card-amber:hover {
        box-shadow: 0 20px 40px -10px rgba(245, 158, 11, 0.18);
    }
    .action-card-rose:hover {
        box-shadow: 0 20px 40px -10px rgba(239, 68, 68, 0.16);
    }

    .stat-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
    }

    .gradient-text {
        background: linear-gradient(135deg, #0ea5e9, #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-bg {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 40%, #fef3c7 80%, #fff7ed 100%);
    }

    .bg-dot-pattern {
        background-image: radial-gradient(circle, rgba(14,165,233,0.12) 1px, transparent 1px);
        background-size: 24px 24px;
    }

    .guide-step {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .guide-step:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(14,165,233,0.15);
    }

    .shimmer-text {
        background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 40%, #0ea5e9 80%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }
</style>

<div class="min-h-screen" style="background: linear-gradient(160deg, #f0f9ff 0%, #e0f2fe 30%, #fef9ee 70%, #f0f9ff 100%);">

    <!-- Dot Pattern BG -->
    <div class="fixed inset-0 bg-dot-pattern opacity-40 pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        {{-- ======================= HERO BANNER ======================= --}}
        <div class="anim-slide-up anim-d1 relative rounded-3xl overflow-hidden shadow-xl border border-white/80" style="background: linear-gradient(135deg, #bae6fd 0%, #e0f2fe 35%, #fef3c7 70%, #fed7aa 100%);">

            <!-- Decorative blobs -->
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-sky-300/30 rounded-full blur-3xl pointer-events-none" style="animation: blob 8s ease-in-out infinite;"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-amber-300/30 rounded-full blur-3xl pointer-events-none" style="animation: blob 10s ease-in-out infinite 2s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-32 bg-white/20 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Decorative circles -->
            <div class="absolute top-6 right-6 w-3 h-3 bg-sky-400/60 rounded-full float-slow"></div>
            <div class="absolute top-14 right-20 w-2 h-2 bg-amber-400/60 rounded-full float-medium"></div>
            <div class="absolute bottom-8 left-16 w-2.5 h-2.5 bg-sky-500/50 rounded-full float-slow" style="animation-delay:1.5s;"></div>
            <div class="absolute bottom-6 right-32 w-2 h-2 bg-amber-500/50 rounded-full float-medium" style="animation-delay:0.8s;"></div>

            <div class="relative z-10 p-8 sm:p-10">
                <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-8">
                    <!-- Left: Greeting -->
                    <div class="text-center lg:text-left flex-1">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 backdrop-blur-sm border border-white/90 shadow-sm text-sky-700 text-xs font-bold tracking-wide mb-5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            Portal Pegawai &bull; BDI Padang
                        </div>

                        <!-- Greeting Text -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 mb-3 leading-tight tracking-tight">
                            Selamat datang,<br>
                            <span class="shimmer-text">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="text-slate-600 text-base sm:text-lg max-w-lg mx-auto lg:mx-0 leading-relaxed font-medium">
                            Lakukan peminjaman aset BMN dan laporkan kerusakan dengan mudah dan cepat melalui portal ini.
                        </p>

                        <!-- Date & Time -->
                        <div class="mt-5 inline-flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm">
                            <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="live-date" class="text-slate-600 text-sm font-semibold"></span>
                            <div class="w-px h-4 bg-slate-300"></div>
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span id="live-time" class="text-slate-600 text-sm font-bold font-mono"></span>
                        </div>
                    </div>

                    <!-- Right: Decorative Icon -->
                    <div class="flex-shrink-0 hidden md:flex items-center justify-center">
                        <div class="relative">
                            <div class="w-36 h-36 rounded-3xl bg-white/50 backdrop-blur-sm border border-white/80 shadow-xl flex items-center justify-center float-slow" style="rotate: 6deg;">
                                <svg class="w-20 h-20" viewBox="0 0 80 80" fill="none">
                                    <rect x="8" y="16" width="40" height="52" rx="4" fill="#e0f2fe" stroke="#0ea5e9" stroke-width="2"/>
                                    <rect x="16" y="24" width="24" height="3" rx="1.5" fill="#0ea5e9" opacity="0.7"/>
                                    <rect x="16" y="31" width="18" height="3" rx="1.5" fill="#0ea5e9" opacity="0.5"/>
                                    <rect x="16" y="38" width="21" height="3" rx="1.5" fill="#0ea5e9" opacity="0.4"/>
                                    <circle cx="58" cy="56" r="16" fill="#fef3c7" stroke="#f59e0b" stroke-width="2"/>
                                    <path d="M51 56l5 5 9-9" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <!-- Small decorative cards -->
                            <div class="absolute -top-4 -left-6 w-14 h-14 rounded-2xl bg-sky-500/15 border border-sky-200/60 backdrop-blur-sm float-medium" style="animation-delay:1s;"></div>
                            <div class="absolute -bottom-3 -right-5 w-10 h-10 rounded-xl bg-amber-400/20 border border-amber-200/60 float-slow" style="animation-delay:2s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= STAT CARDS ======================= --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-sky-500 to-blue-600 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Ringkasan Aktivitas Anda</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Stat 1: Aset Aktif Dipinjam -->
                <div class="anim-slide-up anim-d2 stat-card bg-white rounded-2xl p-6 border border-sky-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg, #0ea5e9, #6366f1);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-sky-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-sky-50 text-sky-600 border border-sky-100">Aktif</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums" style="animation: count-up 0.5s 0.3s both;">{{ $jumlahDipinjam ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Aset Aktif Dipinjam</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-sky-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-500 transition-all duration-1000" style="width: {{ min(($jumlahDipinjam ?? 0) * 20, 100) }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Stat 2: Peminjaman Pending -->
                <div class="anim-slide-up anim-d3 stat-card bg-white rounded-2xl p-6 border border-amber-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg, #f59e0b, #ef4444);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-amber-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            @if(($jumlahPending ?? 0) > 0)
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100 flex items-center gap-1">
                                    <span class="relative flex h-1.5 w-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span><span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span></span>
                                    Menunggu
                                </span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-50 text-slate-400 border border-slate-100">Kosong</span>
                            @endif
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $jumlahPending ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Peminjaman Pending</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-amber-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-500 transition-all duration-1000" style="width: {{ min(($jumlahPending ?? 0) * 20, 100) }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Laporan Diproses -->
                <div class="anim-slide-up anim-d4 stat-card bg-white rounded-2xl p-6 border border-indigo-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-indigo-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100">Diproses</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $jumlahLaporanDiproses ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Laporan Diproses</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-indigo-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 transition-all duration-1000" style="width: {{ min(($jumlahLaporanDiproses ?? 0) * 20, 100) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= QUICK ACTIONS ======================= --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-amber-400 to-orange-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Akses Cepat</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Action 1: Katalog Aset -->
                <a href="{{ route('pegawai.katalog_aset.index') }}" class="anim-slide-up anim-d2 action-card group block bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                    <!-- Top colored bar -->
                    <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #0ea5e9, #3b82f6);"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center group-hover:bg-sky-100 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-sky-600 transition-colors">Katalog Aset</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Telusuri dan ajukan peminjaman aset BMN yang tersedia.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-xs font-bold text-sky-600 bg-sky-50 border border-sky-100 px-2.5 py-1 rounded-full">Lihat Katalog</span>
                        </div>
                    </div>
                </a>

                <!-- Action 2: Peminjaman -->
                <a href="{{ route('pegawai.peminjaman.index') }}" class="anim-slide-up anim-d3 action-card action-card-amber group block bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                    <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #f59e0b, #f97316);"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center group-hover:bg-amber-100 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-amber-600 transition-colors">Peminjaman Saya</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Pantau status semua pengajuan peminjaman aset Anda.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-full">Pantau Status</span>
                            @if(($jumlahPending ?? 0) > 0)
                                <span class="text-xs font-bold text-white bg-amber-500 px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span class="relative flex h-1.5 w-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span><span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span></span>
                                    {{ $jumlahPending }} Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </a>

                <!-- Action 3: Laporan Kerusakan -->
                <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="anim-slide-up anim-d4 action-card action-card-rose group block bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                    <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #ef4444, #f97316);"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center group-hover:bg-red-100 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-red-600 transition-colors">Lapor Kerusakan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Laporkan kerusakan atau kendala pada aset secara langsung.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">Buat Laporan</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- ======================= PANDUAN CEPAT ======================= --}}
        <div class="anim-slide-up anim-d5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Panduan Penggunaan</h2>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-6 sm:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Step 1 -->
                    <div class="guide-step bg-sky-50/60 rounded-xl p-5 border border-sky-100 text-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-sky-500 text-white text-xs font-black flex items-center justify-center mx-auto mb-2">1</div>
                        <h4 class="text-sm font-black text-slate-800 mb-1">Cari Aset</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Buka <strong class="text-sky-600">Katalog Aset</strong> dan temukan aset yang ingin dipinjam.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="guide-step bg-amber-50/60 rounded-xl p-5 border border-amber-100 text-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-amber-500 text-white text-xs font-black flex items-center justify-center mx-auto mb-2">2</div>
                        <h4 class="text-sm font-black text-slate-800 mb-1">Ajukan Pinjam</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Klik tombol <strong class="text-amber-600">Pinjam</strong> dan isi formulir dengan data yang benar.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="guide-step bg-indigo-50/60 rounded-xl p-5 border border-indigo-100 text-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-indigo-500 text-white text-xs font-black flex items-center justify-center mx-auto mb-2">3</div>
                        <h4 class="text-sm font-black text-slate-800 mb-1">Tunggu Persetujuan</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Kasubag TU akan meninjau dan menyetujui pengajuan Anda.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="guide-step bg-emerald-50/60 rounded-xl p-5 border border-emerald-100 text-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center justify-center mx-auto mb-2">4</div>
                        <h4 class="text-sm font-black text-slate-800 mb-1">Ambil & Kembalikan</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Setelah disetujui, ambil aset dan kembalikan tepat waktu.</p>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="mt-6 flex items-start gap-3 p-4 rounded-xl bg-sky-50 border border-sky-100">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 border border-sky-200 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-sky-800 mb-0.5">Menemukan aset rusak atau bermasalah?</p>
                        <p class="text-xs text-sky-600 font-medium leading-relaxed">Segera laporkan melalui menu <strong>Lapor Kerusakan</strong> agar dapat segera ditangani oleh tim teknis. Laporan Anda sangat membantu kelancaran operasional kantor.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Live date & time display
    function updateClock() {
        const now = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const dateEl = document.getElementById('live-date');
        const timeEl = document.getElementById('live-time');

        if (dateEl) dateEl.textContent = `${dayName}, ${date} ${month} ${year}`;
        if (timeEl) timeEl.textContent = `${hours}:${minutes}:${seconds}`;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
