@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">{{ __('Dashboard Executive') }}</h2>
                <p class="text-sm text-slate-500 font-medium">Ringkasan persetujuan dan pengawasan BMN.</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-xs font-medium text-indigo-500 bg-indigo-50 border border-indigo-100 px-2.5 py-0.5 rounded-full inline-block mt-0.5">Kasubag TU</p>
        </div>
    </div>
@endsection

@section('content')
<style>
    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-16px) rotate(3deg); }
    }
    @keyframes float-medium {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }
    @keyframes blob {
        0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50%       { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    }
    @keyframes pulse-badge {
        0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0.4); }
        50%       { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
    }

    .anim-slide-up  { animation: slide-up 0.55s ease both; }
    .anim-d1 { animation-delay: 0.05s; }
    .anim-d2 { animation-delay: 0.15s; }
    .anim-d3 { animation-delay: 0.25s; }
    .anim-d4 { animation-delay: 0.35s; }
    .anim-d5 { animation-delay: 0.45s; }
    .anim-d6 { animation-delay: 0.55s; }

    .float-slow   { animation: float-slow   6s ease-in-out infinite; }
    .float-medium { animation: float-medium 4.5s ease-in-out infinite; }

    .shimmer-text {
        background: linear-gradient(90deg, #6366f1 0%, #0ea5e9 40%, #6366f1 80%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    .approval-card {
        transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s ease;
    }
    .approval-card:hover { transform: translateY(-6px); }

    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover { transform: translateY(-3px); }

    .bg-dot-pattern {
        background-image: radial-gradient(circle, rgba(99,102,241,0.1) 1px, transparent 1px);
        background-size: 24px 24px;
    }

    .urgent-pulse { animation: pulse-badge 2s ease-in-out infinite; }

    .action-link {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .action-link:hover { transform: translateX(3px); }
</style>

<div class="min-h-screen" style="background: linear-gradient(160deg, #f0f9ff 0%, #e0f2fe 25%, #ede9fe 55%, #fef9ee 100%);">

    <!-- Dot pattern overlay -->
    <div class="fixed inset-0 bg-dot-pattern opacity-40 pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        {{-- ====================== HERO BANNER ====================== --}}
        <div class="anim-slide-up anim-d1 relative rounded-3xl overflow-hidden shadow-xl border border-white/80"
             style="background: linear-gradient(135deg, #c7d2fe 0%, #ddd6fe 30%, #bae6fd 65%, #fef3c7 100%);">

            <!-- Decorative blobs -->
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-indigo-300/30 rounded-full blur-3xl pointer-events-none" style="animation: blob 9s ease-in-out infinite;"></div>
            <div class="absolute -bottom-20 -left-20 w-52 h-52 bg-sky-300/25 rounded-full blur-3xl pointer-events-none" style="animation: blob 11s ease-in-out infinite 2s;"></div>
            <div class="absolute top-1/2 left-1/3 w-80 h-24 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Floating dots -->
            <div class="absolute top-6   right-8  w-3   h-3   bg-indigo-400/50 rounded-full float-slow"></div>
            <div class="absolute top-16  right-24 w-2   h-2   bg-amber-400/60  rounded-full float-medium" style="animation-delay:0.8s;"></div>
            <div class="absolute bottom-8 left-16 w-2.5 h-2.5 bg-sky-500/40   rounded-full float-slow"   style="animation-delay:1.5s;"></div>
            <div class="absolute bottom-5 right-40 w-2  h-2   bg-purple-400/50 rounded-full float-medium" style="animation-delay:2.2s;"></div>

            <div class="relative z-10 p-8 sm:p-10">
                <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-8">

                    <!-- Left: Greeting -->
                    <div class="text-center lg:text-left flex-1">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 backdrop-blur-sm border border-white/90 shadow-sm text-indigo-700 text-xs font-bold tracking-wide mb-5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            Portal Eksekutif &bull; BDI Padang
                        </div>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 mb-3 leading-tight tracking-tight">
                            Selamat datang,<br>
                            <span class="shimmer-text">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="text-slate-600 text-base sm:text-lg max-w-lg mx-auto lg:mx-0 leading-relaxed font-medium">
                            Pantau dan setujui seluruh aktivitas peminjaman serta pemeliharaan Barang Milik Negara agar operasional kantor berjalan lancar.
                        </p>

                        <!-- Date & Time -->
                        <div class="mt-5 inline-flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white/60 backdrop-blur-sm border border-white/80 shadow-sm">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="live-date" class="text-slate-600 text-sm font-semibold"></span>
                            <div class="w-px h-4 bg-slate-300"></div>
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span id="live-time" class="text-slate-600 text-sm font-bold font-mono"></span>
                        </div>
                    </div>

                    <!-- Right: Total Pending Counter -->
                    <div class="flex-shrink-0 hidden md:flex items-center justify-center">
                        <div class="relative float-slow">
                            <div class="w-40 h-40 rounded-3xl bg-white/55 backdrop-blur-sm border border-white/80 shadow-xl flex flex-col items-center justify-center text-center" style="rotate: 5deg;">
                                <p class="text-indigo-700 text-xs font-black uppercase tracking-widest mb-1">Total Pending</p>
                                <p class="text-6xl font-black leading-none mb-1
                                    {{ ($jumlahPending ?? 0) > 0 ? 'text-amber-500' : 'text-slate-400' }}">
                                    {{ $jumlahPending ?? 0 }}
                                </p>
                                <p class="text-slate-500 text-xs font-semibold">persetujuan</p>
                            </div>
                            @if(($jumlahPending ?? 0) > 0)
                                <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-red-500 border-2 border-white flex items-center justify-center shadow-md urgent-pulse">
                                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                </div>
                            @endif
                            <!-- Small decorative -->
                            <div class="absolute -top-5 -left-5 w-14 h-14 rounded-2xl bg-indigo-200/40 border border-indigo-200/50 float-medium" style="animation-delay:1s;"></div>
                            <div class="absolute -bottom-4 -right-4 w-10 h-10 rounded-xl bg-amber-200/40 border border-amber-200/50 float-slow" style="animation-delay:2s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== STAT SUMMARY ROW ====================== --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Ringkasan Antrean Persetujuan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <!-- Stat: Total Pending -->
                <div class="anim-slide-up anim-d2 stat-card bg-white rounded-2xl p-6 border border-indigo-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg,#6366f1,#8b5cf6);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-indigo-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg,#6366f1,#8b5cf6);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            @if(($jumlahPending ?? 0) > 0)
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 flex items-center gap-1">
                                    <span class="relative flex h-1.5 w-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span></span>
                                    Perlu Tindakan
                                </span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Semua Selesai</span>
                            @endif
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $jumlahPending ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Total Menunggu Persetujuan</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-indigo-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 transition-all duration-1000" style="width: {{ min(($jumlahPending ?? 0) * 15, 100) }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Stat: Peminjaman Pending -->
                <div class="anim-slide-up anim-d3 stat-card bg-white rounded-2xl p-6 border border-sky-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg,#0ea5e9,#3b82f6);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-sky-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg,#0ea5e9,#3b82f6);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-sky-50 text-sky-600 border border-sky-100">Peminjaman</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $jumlahPeminjamanPending ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Peminjaman Pending</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-sky-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-500 transition-all duration-1000" style="width: {{ min(($jumlahPeminjamanPending ?? 0) * 20, 100) }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Stat: Pemeliharaan Pending -->
                <div class="anim-slide-up anim-d4 stat-card bg-white rounded-2xl p-6 border border-rose-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg,#f43f5e,#f97316);"></div>
                    <div class="absolute -top-8 -right-8 w-28 h-28 bg-rose-100 rounded-full opacity-60"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg,#f43f5e,#f97316);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-100">Pemeliharaan</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $jumlahPemeliharaanPending ?? 0 }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Pemeliharaan Pending</div>
                        <div class="mt-3 h-1 w-full rounded-full bg-rose-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-orange-500 transition-all duration-1000" style="width: {{ min(($jumlahPemeliharaanPending ?? 0) * 20, 100) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== APPROVAL ACTION CARDS ====================== --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-sky-500 to-blue-600 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Menunggu Persetujuan Anda</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Card Peminjaman Aset --}}
                <div class="anim-slide-up anim-d3 approval-card bg-white rounded-2xl border border-slate-100 shadow-md overflow-hidden relative">
                    <!-- Top accent bar -->
                    <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #0ea5e9, #3b82f6);"></div>

                    <!-- Background decoration -->
                    <div class="absolute top-0 right-0 w-40 h-40 rounded-bl-full pointer-events-none" style="background: linear-gradient(225deg, #e0f2fe, transparent);"></div>

                    <div class="p-7 relative z-10">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6);">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-800 leading-tight">Peminjaman Aset</h3>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Pengajuan pinjam barang oleh pegawai</p>
                                </div>
                            </div>
                            @if(($jumlahPeminjamanPending ?? 0) > 0)
                                <span class="flex h-3 w-3 relative mt-1">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                                </span>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-100 my-4"></div>

                        <!-- Count + CTA -->
                        <div class="flex items-end justify-between">
                            <div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-5xl font-black text-slate-900 tabular-nums leading-none">{{ $jumlahPeminjamanPending ?? 0 }}</span>
                                    <span class="text-sm font-bold text-slate-400">antrean</span>
                                </div>
                                @if(($jumlahPeminjamanPending ?? 0) > 0)
                                    <p class="text-xs text-sky-600 font-semibold mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        Memerlukan persetujuan segera
                                    </p>
                                @else
                                    <p class="text-xs text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Tidak ada antrean
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('kasubag.persetujuan.index', ['tab' => 'pending']) }}"
                               class="action-link inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-lg transition-all duration-200"
                               style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); box-shadow: 0 8px 20px -6px rgba(14,165,233,0.5);">
                                Tinjau Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                        <!-- Progress bar -->
                        <div class="mt-5 h-1.5 w-full rounded-full bg-sky-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-500 transition-all duration-1000"
                                 style="width: {{ ($jumlahPeminjamanPending ?? 0) > 0 ? min(($jumlahPeminjamanPending ?? 0) * 20, 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Card Pemeliharaan Aset --}}
                <div class="anim-slide-up anim-d4 approval-card bg-white rounded-2xl border border-slate-100 shadow-md overflow-hidden relative">
                    <!-- Top accent bar -->
                    <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #f43f5e, #f97316);"></div>

                    <!-- Background decoration -->
                    <div class="absolute top-0 right-0 w-40 h-40 rounded-bl-full pointer-events-none" style="background: linear-gradient(225deg, #fff1f2, transparent);"></div>

                    <div class="p-7 relative z-10">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #f43f5e, #f97316);">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-800 leading-tight">Pemeliharaan Aset</h3>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Laporan kerusakan dan perbaikan aset</p>
                                </div>
                            </div>
                            @if(($jumlahPemeliharaanPending ?? 0) > 0)
                                <span class="flex h-3 w-3 relative mt-1">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                </span>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-100 my-4"></div>

                        <!-- Count + CTA -->
                        <div class="flex items-end justify-between">
                            <div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-5xl font-black text-slate-900 tabular-nums leading-none">{{ $jumlahPemeliharaanPending ?? 0 }}</span>
                                    <span class="text-sm font-bold text-slate-400">antrean</span>
                                </div>
                                @if(($jumlahPemeliharaanPending ?? 0) > 0)
                                    <p class="text-xs text-rose-600 font-semibold mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        Memerlukan persetujuan segera
                                    </p>
                                @else
                                    <p class="text-xs text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Tidak ada antrean
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'pending']) }}"
                               class="action-link inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-lg transition-all duration-200"
                               style="background: linear-gradient(135deg, #f43f5e, #f97316); box-shadow: 0 8px 20px -6px rgba(244,63,94,0.45);">
                                Tinjau Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                        <!-- Progress bar -->
                        <div class="mt-5 h-1.5 w-full rounded-full bg-rose-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-orange-500 transition-all duration-1000"
                                 style="width: {{ ($jumlahPemeliharaanPending ?? 0) > 0 ? min(($jumlahPemeliharaanPending ?? 0) * 20, 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ====================== QUICK NAVIGATION ====================== --}}
        <div class="anim-slide-up anim-d5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-amber-400 to-orange-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Navigasi Cepat</h2>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                    <!-- Nav 1: Data Aset -->
                    <a href="{{ route('kasubag.aset.index') }}"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-sky-50 hover:border-sky-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background: linear-gradient(135deg,#0ea5e9,#3b82f6);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-sky-700 transition-colors leading-tight">Data Aset BMN</span>
                    </a>

                    <!-- Nav 2: Data Ruangan -->
                    <a href="{{ route('kasubag.ruangan.index') }}"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background: linear-gradient(135deg,#6366f1,#8b5cf6);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-700 transition-colors leading-tight">Data Ruangan</span>
                    </a>

                    <!-- Nav 3: Approval Peminjaman -->
                    <a href="{{ route('kasubag.persetujuan.index') }}"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-sky-50 hover:border-sky-200 transition-all duration-200 text-center relative">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        @if(($jumlahPeminjamanPending ?? 0) > 0)
                            <span class="absolute top-2 right-2 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center shadow-sm">{{ $jumlahPeminjamanPending }}</span>
                        @endif
                        <span class="text-xs font-bold text-slate-600 group-hover:text-sky-700 transition-colors leading-tight">Approval Peminjaman</span>
                    </a>

                    <!-- Nav 4: Approval Pemeliharaan -->
                    <a href="{{ route('kasubag.persetujuan_pemeliharaan.index') }}"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-rose-50 hover:border-rose-200 transition-all duration-200 text-center relative">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background: linear-gradient(135deg,#f43f5e,#f97316);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                        </div>
                        @if(($jumlahPemeliharaanPending ?? 0) > 0)
                            <span class="absolute top-2 right-2 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center shadow-sm">{{ $jumlahPemeliharaanPending }}</span>
                        @endif
                        <span class="text-xs font-bold text-slate-600 group-hover:text-rose-700 transition-colors leading-tight">Approval Pemeliharaan</span>
                    </a>

                </div>

                <!-- Info note -->
                <div class="mt-5 flex items-start gap-3 p-4 rounded-xl bg-indigo-50 border border-indigo-100">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 border border-indigo-200 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-indigo-800 mb-0.5">Peran Kasubag TU</p>
                        <p class="text-xs text-indigo-600 font-medium leading-relaxed">Anda bertugas menyetujui atau menolak setiap pengajuan peminjaman dan laporan pemeliharaan aset dari seluruh pegawai. Pastikan setiap pengajuan ditinjau tepat waktu.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        const dayName = days[now.getDay()];
        const date    = now.getDate();
        const month   = months[now.getMonth()];
        const year    = now.getFullYear();

        const hh = String(now.getHours()).padStart(2,'0');
        const mm = String(now.getMinutes()).padStart(2,'0');
        const ss = String(now.getSeconds()).padStart(2,'0');

        const dateEl = document.getElementById('live-date');
        const timeEl = document.getElementById('live-time');
        if (dateEl) dateEl.textContent = `${dayName}, ${date} ${month} ${year}`;
        if (timeEl) timeEl.textContent = `${hh}:${mm}:${ss}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
