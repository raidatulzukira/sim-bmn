@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-sky-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Riwayat Laporan Kerusakan') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Pantau status laporan perbaikan aset Anda di sini.</p>
            </div>
        </div>
        <a href="{{ route('pegawai.laporan_kerusakan.create') }}" class="group relative inline-flex items-center gap-2 px-6 py-3 bg-sky-600 text-white font-bold rounded-xl shadow-lg shadow-sky-200 hover:bg-sky-700 hover:shadow-sky-300 transition-all duration-300 transform hover:-translate-y-0.5 overflow-hidden">
            <!-- <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span> -->
            <svg class="w-5 h-5 relative z-10 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="relative z-10">Lapor Kerusakan</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col sm:flex-row justify-between items-center gap-4 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center gap-3 text-slate-700 font-bold w-full sm:w-auto">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Laporan
                </div>
                <form method="GET" action="{{ route('pegawai.laporan_kerusakan.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <select name="status" class="bg-slate-50 border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full sm:w-48 p-2.5 font-medium transition-colors">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses Servis</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 transition-colors shadow-sm w-full sm:w-auto">Terapkan</button>
                        @if(request('status'))
                            <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="px-5 py-2.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-sm font-bold hover:bg-rose-100 hover:border-rose-300 transition-colors shadow-sm text-center w-full sm:w-auto">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. Nota</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aset BMN</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Lapor</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($laporans as $laporan)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                        {{ $laporan->batch_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600 border border-sky-100 shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                                                    {{ $laporan->asetBmn ? $laporan->asetBmn->nama_barang : 'Belum diidentifikasi' }}
                                                    @if($laporan->total_barang > 1)
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                                                            {{ $laporan->total_barang }} Unit
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-500 mt-0.5">
                                                    NUP: <span class="font-medium text-slate-700">{{ $laporan->asetBmn ? $laporan->asetBmn->nup : '-' }}</span>
                                                    @if($laporan->total_barang > 1)
                                                        <span class="text-slate-400 italic">... (dan lainnya)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 max-w-xs truncate font-medium" title="{{ $laporan->deskripsi_kerusakan }}">
                                            {{ $laporan->deskripsi_kerusakan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-700">{{ $laporan->tanggal_pengajuan->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $laporan->tanggal_pengajuan->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badge = match($laporan->status) {
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'disetujui' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'proses' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                default => 'bg-slate-50 text-slate-700 border-slate-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $badge }} uppercase tracking-wider">
                                            {{ $laporan->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('pegawai.laporan_kerusakan.show', $laporan->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all shadow-sm group/btn">
                                            <span class="text-xs font-bold">Detail</span>
                                            <svg class="w-4 h-4 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <h3 class="text-sm font-bold text-slate-900 mb-1">Belum Ada Riwayat</h3>
                                            <p class="text-sm text-slate-500">Anda belum pernah melaporkan kerusakan aset apapun.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($laporans->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $laporans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
