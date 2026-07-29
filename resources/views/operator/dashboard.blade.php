@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        {{ __('Dashboard Operator') }}
    </h2>
@endsection

@section('content')

<style>
    /* ===== DASHBOARD ANIMATIONS ===== */
    @keyframes fade-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scale-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    @keyframes blob { 0%,100% { transform: translate(0,0) scale(1); } 33% { transform: translate(20px,-15px) scale(1.05); } 66% { transform: translate(-10px,10px) scale(0.95); } }
    @keyframes pulse-dot { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.5);} 50%{box-shadow:0 0 0 6px rgba(239,68,68,0);} }
    
    .dash-card { animation: fade-up 0.6s cubic-bezier(0.16,1,0.3,1) both; }
    .dash-card:nth-child(1) { animation-delay: 0.05s; }
    .dash-card:nth-child(2) { animation-delay: 0.1s; }
    .dash-card:nth-child(3) { animation-delay: 0.15s; }
    .dash-card:nth-child(4) { animation-delay: 0.2s; }
    .dash-section { animation: scale-in 0.6s cubic-bezier(0.16,1,0.3,1) both; }
    .dash-section:nth-child(1) { animation-delay: 0.25s; }
    .dash-section:nth-child(2) { animation-delay: 0.3s; }
    .dash-section:nth-child(3) { animation-delay: 0.35s; }

    .blob-deco { animation: blob 12s ease-in-out infinite; }
    .blob-deco-2 { animation: blob 16s ease-in-out infinite reverse; animation-delay: -4s; }

    .dash-dot-grid { background-image: radial-gradient(circle, rgba(15,23,42,0.04) 1px, transparent 1px); background-size: 24px 24px; }

    .stat-card { transition: all 0.35s cubic-bezier(0.16,1,0.3,1); }
    .stat-card:hover { transform: translateY(-6px); }

    .alert-row { transition: background-color 0.2s ease; }
    .alert-row:hover { background-color: #f8fafc; }

    .urgent-dot { animation: pulse-dot 2s infinite; }

    /* ===== GRADIENT UTILITIES ===== */
    .grad-text-blue { background: linear-gradient(135deg, #0284c7, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
</style>

<div class="min-h-screen bg-slate-50 dash-dot-grid relative overflow-hidden">
    
    <!-- Decorative Blobs -->
    <div class="blob-deco absolute w-[400px] h-[400px] -top-40 -right-20 bg-sky-200/30 rounded-full blur-3xl pointer-events-none z-0"></div>
    <div class="blob-deco-2 absolute w-[350px] h-[350px] bottom-0 -left-20 bg-blue-200/20 rounded-full blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ===== 1. WELCOME BANNER ===== --}}
        <div class="dash-card relative bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden" style="animation-delay:0s">
            <div class="absolute inset-0 bg-gradient-to-r from-sky-50 via-blue-50 to-slate-50 pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-sky-100/50 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl pointer-events-none"></div>
            <div class="relative z-10 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-5">
                    <!-- Avatar -->
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-700 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-sky-500/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></div>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-semibold mb-0.5">Selamat datang kembali,</p>
                        <h1 class="text-2xl font-black text-slate-800 leading-tight">{{ Auth::user()->name }}</h1>
                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-700 text-xs font-bold">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                Operator
                            </span>
                            <span class="text-slate-400 text-xs font-medium">Balai Diklat Industri Padang</span>
                        </div>
                    </div>
                </div>
                <!-- Date & Quick Info -->
                <div class="text-right shrink-0">
                    <p class="text-slate-800 font-black text-base">{{ now()->translatedFormat('l') }}</p>
                    <p class="text-slate-500 text-sm font-medium">{{ now()->translatedFormat('d F Y') }}</p>
                    <div class="flex items-center gap-1.5 justify-end mt-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 urgent-dot"></div>
                        <span class="text-emerald-600 text-xs font-bold">Sistem Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== 2. STATISTICS CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Total Aset --}}
            <div class="dash-card stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-sky-500/10 hover:border-sky-200 group">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-13 h-13 p-3 rounded-2xl bg-gradient-to-br from-sky-400 to-blue-600 shadow-lg shadow-sky-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-sky-600 bg-sky-50 border border-sky-100 px-2 py-1 rounded-lg">BMN</span>
                </div>
                <p class="text-4xl font-black text-slate-800 mb-1 leading-none">{{ $totalAset }}</p>
                <p class="text-slate-500 text-sm font-semibold">Total Aset BMN</p>
                <div class="mt-4 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-600" style="width: 100%"></div>
                </div>
            </div>

            {{-- Aset Dipinjam --}}
            <div class="dash-card stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-200 group">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-13 h-13 p-3 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 border border-amber-100 px-2 py-1 rounded-lg">Aktif</span>
                </div>
                <p class="text-4xl font-black text-slate-800 mb-1 leading-none">{{ $asetDipinjam }}</p>
                <p class="text-slate-500 text-sm font-semibold">Aset Dipinjam</p>
                <div class="mt-4 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    @php $pctPinjam = $totalAset > 0 ? round(($asetDipinjam/$totalAset)*100, 1) : 0; @endphp
                    <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-500" style="width: {{ $pctPinjam }}%"></div>
                </div>
                <p class="text-[11px] text-slate-400 font-semibold mt-1">{{ $pctPinjam }}% dari total aset</p>
            </div>

            {{-- Aset Servis --}}
            <div class="dash-card stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-rose-500/10 hover:border-rose-200 group">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-13 h-13 p-3 rounded-2xl bg-gradient-to-br from-rose-400 to-red-600 shadow-lg shadow-rose-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    @if($asetServis > 0)
                        <span class="text-[10px] font-bold uppercase tracking-widest text-rose-600 bg-rose-50 border border-rose-100 px-2 py-1 rounded-lg flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping inline-block"></span>
                            Perlu Aksi
                        </span>
                    @else
                        <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">Aman</span>
                    @endif
                </div>
                <p class="text-4xl font-black text-slate-800 mb-1 leading-none">{{ $asetServis }}</p>
                <p class="text-slate-500 text-sm font-semibold">Aset Dalam Servis</p>
                <div class="mt-4 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    @php $pctServis = $totalAset > 0 ? round(($asetServis/$totalAset)*100, 1) : 0; @endphp
                    <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-red-600" style="width: {{ max(4, $pctServis) }}%"></div>
                </div>
                <p class="text-[11px] text-slate-400 font-semibold mt-1">{{ $pctServis }}% dari total aset</p>
            </div>

            {{-- Butuh Jadwal Servis --}}
            <div class="dash-card stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-200 group">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-13 h-13 p-3 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-600 shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @if($asetMembutuhkanServis->count() > 0)
                        <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-1 rounded-lg">Perhatian</span>
                    @else
                        <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">Aman</span>
                    @endif
                </div>
                <p class="text-4xl font-black text-slate-800 mb-1 leading-none">{{ $asetMembutuhkanServis->count() }}</p>
                <p class="text-slate-500 text-sm font-semibold">Butuh Jadwal Servis</p>
                <div class="mt-4 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-purple-600" style="width: {{ $asetMembutuhkanServis->count() > 0 ? '100%' : '4%' }}"></div>
                </div>
                <p class="text-[11px] text-slate-400 font-semibold mt-1">H-30 atau sudah terlewat</p>
            </div>

        </div>

        {{-- ===== 3. ALERT GRID ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Peminjaman Mendekati Jatuh Tempo --}}
            <div class="dash-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <!-- Card Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-rose-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 border border-rose-200 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-800">Peminjaman Mendekati Jatuh Tempo</h3>
                            <p class="text-xs text-slate-500 font-medium">Batas waktu pengembalian dalam H-2</p>
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
                                        <tr class="alert-row">
                                            <td class="px-4 py-3.5 whitespace-nowrap">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-7 h-7 rounded-full bg-sky-100 border border-sky-200 flex items-center justify-center text-sky-700 text-xs font-black shrink-0">
                                                        {{ strtoupper(substr($pinjam->user->name, 0, 1)) }}
                                                    </div>
                                                    <span class="text-sm font-semibold text-slate-700">{{ $pinjam->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-600 font-medium">{{ $pinjam->asetBmn->nama_barang }}</td>
                                            <td class="px-4 py-3.5 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-100 text-rose-700 font-bold rounded-full text-xs">
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
                            <p class="text-slate-400 text-xs mt-1 font-medium">Tidak ada peminjaman yang mendekati jatuh tempo (H-2).</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pemeliharaan Perlu Tindakan --}}
            <div class="dash-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <!-- Card Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
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
                                        <tr class="alert-row">
                                            <td class="px-4 py-3.5 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $rawat->asetBmn->nama_barang }}</td>
                                            <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-600 capitalize font-medium">{{ $rawat->jenis }}</td>
                                            <td class="px-4 py-3.5 whitespace-nowrap">
                                                @if($rawat->status == 'pending')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold border border-rose-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span>
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                                        {{ ucfirst($rawat->status) }}
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

        {{-- ===== 4. JADWAL SERVIS RUTIN ===== --}}
        <div class="dash-section bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 border border-indigo-200 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800">Jadwal Servis Rutin Aset</h3>
                        <p class="text-xs text-slate-500 font-medium">Aset yang mendekati (H-30) atau telah melewati jadwal servis</p>
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
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Jadwal Servis Berikutnya</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($asetMembutuhkanServis as $aset)
                                    <tr class="alert-row bg-rose-50/30">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-slate-800">{{ $aset->nama_barang }}</div>
                                                    <div class="text-xs text-slate-400 font-mono">{{ $aset->kode_barang }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                            {{ $aset->tanggal_servis_terakhir->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 font-bold rounded-full text-xs border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 urgent-dot inline-block"></span>
                                                {{ $aset->jadwal_servis_berikutnya->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <a href="{{ route('operator.pemeliharaan.create', ['aset_id' => $aset->id]) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-sky-500 to-blue-600 text-white text-sm font-bold rounded-xl hover:from-sky-600 hover:to-blue-700 transition-all duration-200 shadow-sm shadow-sky-500/30 hover:shadow-md hover:shadow-sky-500/40 hover:-translate-y-0.5">
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

    </div>{{-- End container --}}
</div>{{-- End page wrapper --}}

@endsection
