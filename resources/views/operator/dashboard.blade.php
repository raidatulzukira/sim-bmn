@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #0ea5e9, #2563eb);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">{{ __('Dashboard Operator') }}</h2>
                <p class="text-sm text-slate-500 font-medium">Monitoring aset, peminjaman & pemeliharaan BMN.</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-xs font-medium text-sky-600 bg-sky-50 border border-sky-100 px-2.5 py-0.5 rounded-full inline-block mt-0.5">Operator</p>
        </div>
    </div>
@endsection

@section('content')

<style>
    @keyframes float-slow   { 0%,100%{ transform:translateY(0)   rotate(0deg); } 50%{ transform:translateY(-16px) rotate(3deg); } }
    @keyframes float-medium { 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-10px); } }
    @keyframes slide-up     { from{ opacity:0; transform:translateY(24px); } to{ opacity:1; transform:translateY(0); } }
    @keyframes blob         { 0%,100%{ border-radius:60% 40% 30% 70%/60% 30% 70% 40%; } 50%{ border-radius:30% 60% 70% 40%/50% 60% 30% 60%; } }
    @keyframes shimmer      { 0%{ background-position:-200% center; } 100%{ background-position:200% center; } }
    @keyframes pulse-dot    { 0%,100%{ box-shadow:0 0 0 0 rgba(239,68,68,0.5); } 50%{ box-shadow:0 0 0 6px rgba(239,68,68,0); } }
    @keyframes pulse-green  { 0%,100%{ box-shadow:0 0 0 0 rgba(16,185,129,0.5); } 50%{ box-shadow:0 0 0 6px rgba(16,185,129,0); } }

    .anim-slide-up { animation: slide-up 0.55s ease both; }
    .anim-d1 { animation-delay:.05s; }
    .anim-d2 { animation-delay:.12s; }
    .anim-d3 { animation-delay:.19s; }
    .anim-d4 { animation-delay:.26s; }
    .anim-d5 { animation-delay:.33s; }
    .anim-d6 { animation-delay:.40s; }
    .anim-d7 { animation-delay:.47s; }

    .float-slow   { animation: float-slow   6s ease-in-out infinite; }
    .float-medium { animation: float-medium 4.5s ease-in-out infinite; }

    .shimmer-text {
        background: linear-gradient(90deg,#0ea5e9 0%,#6366f1 40%,#0ea5e9 80%);
        background-size:200% auto;
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
        background-clip:text;
        animation: shimmer 3s linear infinite;
    }

    .bg-dot-pattern {
        background-image: radial-gradient(circle,rgba(14,165,233,0.1) 1px,transparent 1px);
        background-size:24px 24px;
    }

    .stat-card {
        transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }

    .alert-table-row { transition: background-color .15s ease; }
    .alert-table-row:hover { background-color: #f8fafc; }

    .urgent-dot   { animation: pulse-dot   2s infinite; }
    .active-dot   { animation: pulse-green 2s infinite; }

    .section-card {
        transition: box-shadow .25s ease;
    }
    .section-card:hover { box-shadow: 0 8px 24px -8px rgba(14,165,233,0.12); }

    .quick-nav-item {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .quick-nav-item:hover { transform:translateY(-3px); }
</style>

<div class="min-h-screen" style="background:linear-gradient(160deg,#f0f9ff 0%,#e0f2fe 25%,#eff6ff 60%,#fefce8 100%);">
    <div class="fixed inset-0 bg-dot-pattern opacity-40 pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        {{-- ============================= HERO BANNER ============================= --}}
        <div class="anim-slide-up anim-d1 relative rounded-3xl overflow-hidden shadow-xl border border-white/80"
             style="background:linear-gradient(135deg,#bae6fd 0%,#dbeafe 35%,#e0f2fe 65%,#fef9c3 100%);">

            <!-- Decorative blobs -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-sky-300/25 rounded-full blur-3xl pointer-events-none" style="animation:blob 9s ease-in-out infinite;"></div>
            <div class="absolute -bottom-20 -left-20 w-56 h-56 bg-blue-200/20 rounded-full blur-3xl pointer-events-none" style="animation:blob 12s ease-in-out infinite 2s;"></div>
            <div class="absolute top-1/2 left-1/3 w-80 h-20 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Floating dots -->
            <div class="absolute top-6   right-8   w-3   h-3   bg-sky-400/50   rounded-full float-slow"></div>
            <div class="absolute top-14  right-24  w-2   h-2   bg-amber-400/60  rounded-full float-medium" style="animation-delay:.8s;"></div>
            <div class="absolute bottom-8 left-16  w-2.5 h-2.5 bg-blue-500/40  rounded-full float-slow"   style="animation-delay:1.5s;"></div>
            <div class="absolute bottom-5 right-40 w-2   h-2   bg-indigo-400/50 rounded-full float-medium" style="animation-delay:2.2s;"></div>

            <div class="relative z-10 p-8 sm:p-10">
                <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-8">

                    <!-- Left: Greeting -->
                    <div class="flex items-center gap-5 flex-1">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <div class="w-16 h-16 rounded-2xl text-white text-2xl font-black flex items-center justify-center shadow-xl"
                                 style="background:linear-gradient(135deg,#0ea5e9,#2563eb); box-shadow:0 8px 20px -4px rgba(14,165,233,0.5);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full shadow-sm active-dot"></div>
                        </div>

                        <div>
                            <!-- Badge -->
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/70 backdrop-blur-sm border border-white/90 shadow-sm text-sky-700 text-xs font-bold tracking-wide mb-2">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Portal Operator &bull; BDI Padang
                            </div>
                            <p class="text-slate-500 text-sm font-semibold mb-0.5">Selamat datang kembali,</p>
                            <h1 class="text-2xl sm:text-3xl font-black leading-tight tracking-tight">
                                <span class="shimmer-text">{{ Auth::user()->name }}</span>!
                            </h1>
                            <p class="text-slate-600 text-sm font-medium mt-1.5 max-w-md leading-relaxed">
                                Pantau kondisi aset, kelola peminjaman, dan jadwal pemeliharaan Barang Milik Negara dari sini.
                            </p>
                        </div>
                    </div>

                    <!-- Right: Date/Time + System Status -->
                    <div class="flex-shrink-0 hidden md:flex flex-col items-end gap-3">
                        <div class="bg-white/60 backdrop-blur-sm border border-white/80 rounded-2xl px-5 py-4 text-right shadow-sm">
                            <p id="live-day"  class="text-slate-800 font-black text-base leading-none mb-0.5"></p>
                            <p id="live-date" class="text-slate-500 text-sm font-medium mb-2"></p>
                            <p id="live-time" class="text-sky-600 text-xl font-black font-mono tabular-nums"></p>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/60 backdrop-blur-sm border border-emerald-200 rounded-full shadow-sm">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 active-dot"></div>
                            <span class="text-emerald-700 text-xs font-bold">Sistem Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================= STAT CARDS ============================= --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-sky-500 to-blue-600 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Statistik Aset BMN</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                {{-- Total Aset --}}
                <div class="anim-slide-up anim-d2 stat-card bg-white rounded-2xl p-6 border border-sky-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background:linear-gradient(135deg,#0ea5e9,#2563eb);"></div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-sky-100 rounded-full opacity-70"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#0ea5e9,#2563eb);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-sky-600 bg-sky-50 border border-sky-100 px-2 py-1 rounded-lg">BMN</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $totalAset }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Total Aset BMN</div>
                        <div class="mt-3 h-1 rounded-full bg-sky-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-600" style="width:100%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Aset Dipinjam --}}
                <div class="anim-slide-up anim-d3 stat-card bg-white rounded-2xl p-6 border border-amber-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background:linear-gradient(135deg,#f59e0b,#f97316);"></div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-amber-100 rounded-full opacity-70"></div>
                    <div class="relative z-10">
                        @php $pctPinjam = $totalAset > 0 ? round(($asetDipinjam/$totalAset)*100,1) : 0; @endphp
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 border border-amber-100 px-2 py-1 rounded-lg">Aktif</span>
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $asetDipinjam }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Aset Dipinjam</div>
                        <div class="mt-3 h-1 rounded-full bg-amber-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-500" style="width:{{ $pctPinjam }}%;"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1.5">{{ $pctPinjam }}% dari total aset</p>
                    </div>
                </div>

                {{-- Aset Servis --}}
                <div class="anim-slide-up anim-d4 stat-card bg-white rounded-2xl p-6 border border-rose-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background:linear-gradient(135deg,#f43f5e,#ef4444);"></div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-rose-100 rounded-full opacity-70"></div>
                    <div class="relative z-10">
                        @php $pctServis = $totalAset > 0 ? round(($asetServis/$totalAset)*100,1) : 0; @endphp
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#f43f5e,#ef4444);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            @if($asetServis > 0)
                                <span class="text-[10px] font-bold uppercase tracking-widest text-rose-600 bg-rose-50 border border-rose-100 px-2 py-1 rounded-lg flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping inline-block"></span>Perlu Aksi
                                </span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">Aman</span>
                            @endif
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $asetServis }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Aset Dalam Servis</div>
                        <div class="mt-3 h-1 rounded-full bg-rose-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-red-500" style="width:{{ max(4,$pctServis) }}%;"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1.5">{{ $pctServis }}% dari total aset</p>
                    </div>
                </div>

                {{-- Butuh Jadwal Servis --}}
                <div class="anim-slide-up anim-d5 stat-card bg-white rounded-2xl p-6 border border-indigo-100 shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-5" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);"></div>
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-indigo-100 rounded-full opacity-70"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            @if($asetMembutuhkanServis->count() > 0)
                                <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-1 rounded-lg">Perhatian</span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">Aman</span>
                            @endif
                        </div>
                        <div class="text-5xl font-black text-slate-800 leading-none mb-1 tabular-nums">{{ $asetMembutuhkanServis->count() }}</div>
                        <div class="text-sm font-semibold text-slate-500 mt-1">Butuh Jadwal Servis</div>
                        <div class="mt-3 h-1 rounded-full bg-indigo-50 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-purple-600" style="width:{{ $asetMembutuhkanServis->count() > 0 ? '100%' : '4%' }};"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1.5">H-7 atau sudah terlewat</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ============================= ALERT GRID ============================= --}}
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-rose-500 to-amber-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Notifikasi & Peringatan</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Peminjaman Mendekati Jatuh Tempo --}}
                <div class="anim-slide-up anim-d4 section-card bg-white rounded-2xl border border-slate-100 shadow-md overflow-hidden flex flex-col">
                    <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#f43f5e,#f97316);"></div>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100" style="background:linear-gradient(90deg,#fff1f2,#fff);">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#f43f5e,#f97316);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-800">Peminjaman Mendekati Jatuh Tempo</h3>
                                <p class="text-xs text-slate-500 font-medium">Batas waktu pengembalian dalam H-1</p>
                            </div>
                        </div>
                        @if($alertPeminjaman->count() > 0)
                            <span class="shrink-0 w-7 h-7 rounded-full bg-rose-500 text-white text-xs font-black flex items-center justify-center shadow-sm shadow-rose-500/40">{{ $alertPeminjaman->count() }}</span>
                        @else
                            <span class="shrink-0 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200">Aman</span>
                        @endif
                    </div>

                    <div class="p-5 flex-grow">
                        @if($alertPeminjaman->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-100">
                                    <thead>
                                        <tr class="bg-slate-50">
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Peminjam</th>
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Rencana Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @foreach($alertPeminjaman as $pinjam)
                                            <tr class="alert-table-row">
                                                <td class="px-4 py-3.5 whitespace-nowrap">
                                                    <div class="flex items-center gap-2.5">
                                                        <div class="w-7 h-7 rounded-full bg-sky-100 border border-sky-200 flex items-center justify-center text-sky-700 text-xs font-black shrink-0">
                                                            {{ strtoupper(substr($pinjam->user->name, 0, 1)) }}
                                                        </div>
                                                        <span class="text-sm font-semibold text-slate-700">{{ $pinjam->user->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-600 font-medium">
                                                    {{ $pinjam->asetBmn->nama_barang }} <span class="text-xs text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full ml-1">({{ $pinjam->total_barang }} Unit)</span>
                                                </td>
                                                <td class="px-4 py-3.5 whitespace-nowrap">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-100 text-rose-700 font-bold rounded-full text-xs border border-rose-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 urgent-dot inline-block"></span>
                                                        {{ $pinjam->tanggal_kembali_rencana->format('d M Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-slate-700 font-bold text-sm">Semua Tepat Waktu</p>
                                <p class="text-slate-400 text-xs mt-1 font-medium">Tidak ada peminjaman yang mendekati jatuh tempo (H-1).</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Pemeliharaan Perlu Tindakan --}}
                <div class="anim-slide-up anim-d5 section-card bg-white rounded-2xl border border-slate-100 shadow-md overflow-hidden flex flex-col">
                    <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#f59e0b,#10b981);"></div>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100" style="background:linear-gradient(90deg,#fffbeb,#fff);">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-800">Pemeliharaan Perlu Tindakan</h3>
                                <p class="text-xs text-slate-500 font-medium">Status pending atau sedang dalam proses</p>
                            </div>
                        </div>
                        @if($alertPemeliharaan->count() > 0)
                            <span class="shrink-0 w-7 h-7 rounded-full bg-amber-500 text-white text-xs font-black flex items-center justify-center shadow-sm shadow-amber-500/40">{{ $alertPemeliharaan->count() }}</span>
                        @else
                            <span class="shrink-0 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200">Aman</span>
                        @endif
                    </div>

                    <div class="p-5 flex-grow">
                        @if($alertPemeliharaan->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-100">
                                    <thead>
                                        <tr class="bg-slate-50">
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-4 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @foreach($alertPemeliharaan as $rawat)
                                            <tr class="alert-table-row">
                                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-semibold text-slate-700">
                                                    {{ $rawat->asetBmn ? $rawat->asetBmn->nama_barang : 'Aset Belum Diidentifikasi' }}
                                                    @if(isset($rawat->total_barang) && $rawat->total_barang > 1)
                                                        <span class="ml-1.5 px-2 py-0.5 bg-sky-100 text-sky-700 text-[10px] rounded-md border border-sky-200">{{ $rawat->total_barang }} Unit</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-600 capitalize font-medium">{{ $rawat->jenis }}</td>
                                                <td class="px-4 py-3.5 whitespace-nowrap">
                                                    @if($rawat->status == 'pending')
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold border border-rose-200">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span>Pending
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>{{ $rawat->status_label }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-slate-700 font-bold text-sm">Tidak Ada Yang Tertunda</p>
                                <p class="text-slate-400 text-xs mt-1 font-medium">Tidak ada jadwal pemeliharaan yang berstatus pending atau proses.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ============================= JADWAL SERVIS RUTIN ============================= --}}
        <div class="anim-slide-up anim-d6 section-card bg-white rounded-2xl border border-slate-100 shadow-md overflow-hidden">
            <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#6366f1,#8b5cf6,#0ea5e9);"></div>
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100" style="background:linear-gradient(90deg,#eef2ff,#fff);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800">Jadwal Servis Rutin Aset</h3>
                        <p class="text-xs text-slate-500 font-medium">Aset yang mendekati (H-7) atau telah melewati jadwal servis</p>
                    </div>
                </div>
                @if($asetMembutuhkanServis->count() > 0)
                    <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse inline-block"></span>
                        {{ $asetMembutuhkanServis->count() }} Aset
                    </span>
                @else
                    <span class="shrink-0 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-200">Semua Terjadwal</span>
                @endif
            </div>

            <div class="p-5">
                @if($asetMembutuhkanServis->count() > 0)
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Aset BMN</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Servis Terakhir</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Jadwal Berikutnya</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($asetMembutuhkanServis as $aset)
                                    <tr class="alert-table-row bg-rose-50/20">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-slate-800">{{ $aset->nama_barang }}</div>
                                                    <div class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded inline-block mt-1">{{ $aset->total_unit }} Unit</div>
                                                    <div class="text-[10px] text-slate-400 font-mono mt-1">Kode: {{ $aset->kode_barang }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">{{ $aset->contoh_aset->tanggal_servis_terakhir->format('d M Y') }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 font-bold rounded-full text-xs border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 urgent-dot inline-block"></span>
                                                {{ $aset->contoh_aset->jadwal_servis_berikutnya->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <a href="{{ route('operator.pemeliharaan.create', ['kode_barang' => $aset->kode_barang, 'filter' => 'rutin']) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                                               style="background:linear-gradient(135deg,#0ea5e9,#2563eb); box-shadow:0 4px 12px -4px rgba(14,165,233,0.5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                                Ajukan Servis
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-5 shadow-sm">
                            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-slate-700 font-black text-base">Semua Jadwal Aman</p>
                        <p class="text-slate-400 text-sm mt-1 font-medium max-w-sm">Saat ini tidak ada aset yang jadwal servis rutinnya mendekati (H-30) atau terlewat.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============================= QUICK NAVIGATION ============================= --}}
        <div class="anim-slide-up anim-d7">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-6 bg-gradient-to-b from-amber-400 to-orange-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Navigasi Cepat</h2>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                    <a href="{{ route('operator.aset.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-sky-50 hover:border-sky-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#0ea5e9,#2563eb);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-sky-700 transition-colors leading-tight">Kelola Aset</span>
                    </a>

                    <a href="{{ route('operator.pengguna.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-700 transition-colors leading-tight">Kelola Pengguna</span>
                    </a>

                    <a href="{{ route('operator.ruangan.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#10b981,#059669);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-700 transition-colors leading-tight">Kelola Ruangan</span>
                    </a>

                    <a href="{{ route('operator.peminjaman.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-amber-50 hover:border-amber-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-amber-700 transition-colors leading-tight">Kelola Peminjaman</span>
                    </a>

                    <a href="{{ route('operator.pemeliharaan.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-rose-50 hover:border-rose-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#f43f5e,#f97316);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-rose-700 transition-colors leading-tight">Kelola Pemeliharaan</span>
                    </a>

                    <a href="{{ route('operator.laporan.index') }}"
                       class="quick-nav-item group flex flex-col items-center gap-2.5 p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-blue-50 hover:border-blue-200 transition-all duration-200 text-center">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-200" style="background:linear-gradient(135deg,#3b82f6,#6366f1);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 group-hover:text-blue-700 transition-colors leading-tight">Laporan</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function updateClock() {
        const now    = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        const dayEl  = document.getElementById('live-day');
        const dateEl = document.getElementById('live-date');
        const timeEl = document.getElementById('live-time');

        if (dayEl)  dayEl.textContent  = days[now.getDay()];
        if (dateEl) dateEl.textContent = `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        if (timeEl) timeEl.textContent = `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

@endsection
