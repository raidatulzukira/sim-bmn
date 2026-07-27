@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Persetujuan Pemeliharaan') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Tabs -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-2 w-full sm:w-fit">
                <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'pending']) }}" 
                   class="{{ $tab === 'pending' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 {{ $tab === 'pending' ? 'animate-spin-slow' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="{{ $tab === 'pending' ? 'animation: spin 4s linear infinite;' : '' }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Menunggu Persetujuan
                    @if($tab === 'pending' && $pemeliharaans->count() > 0)
                        <span class="ml-1 px-2 py-0.5 bg-white text-indigo-600 rounded-full text-xs animate-pulse">{{ $pemeliharaans->total() }}</span>
                    @endif
                </a>
                <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'riwayat']) }}" 
                   class="{{ $tab === 'riwayat' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Riwayat Diproses
                </a>
            </div>

            <!-- Table Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tgl Pengajuan</th>
                                @if($tab === 'riwayat')
                                    <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                @endif
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($pemeliharaans as $rawat)
                                <tr class="hover:bg-indigo-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <p class="text-sm font-bold text-slate-900">{{ $rawat->asetBmn->nama_barang }}</p>
                                        <p class="text-xs font-mono font-medium text-slate-500 mt-1">{{ $rawat->asetBmn->kode_barang }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $rawat->jenis === 'rutin' ? 'bg-slate-100 border-slate-200 text-slate-700' : 'bg-pink-50 border-pink-200 text-pink-700' }}">
                                            {{ ucfirst($rawat->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600 font-medium">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($rawat->jenis === 'situasional' ? $rawat->pelapor->name : 'Op', 0, 1)) }}
                                            </div>
                                            {{ $rawat->jenis === 'situasional' ? $rawat->pelapor->name : 'Operator' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-500 font-medium">{{ $rawat->tanggal_pengajuan->format('d M Y') }}</td>
                                    
                                    @if($tab === 'riwayat')
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $color = match($rawat->status) {
                                                    'disetujui' => 'bg-blue-50 border-blue-200 text-blue-700',
                                                    'proses' => 'bg-orange-50 border-orange-200 text-orange-700',
                                                    'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                                    'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                                    default => 'bg-slate-50 border-slate-200 text-slate-700'
                                                };
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $color }}">
                                                {{ ucfirst($rawat->status) }}
                                            </span>
                                        </td>
                                    @endif
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2 items-center transition-opacity duration-200">
                                            @if($tab === 'pending')
                                                <a href="{{ route('kasubag.persetujuan_pemeliharaan.show', $rawat->id) }}" class="inline-flex items-center justify-center text-indigo-700 hover:text-indigo-900 bg-indigo-100 px-4 py-2 rounded-xl hover:bg-indigo-200 transition-colors font-bold shadow-sm gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    Review Pengajuan
                                                </a>
                                            @else
                                                <a href="{{ route('kasubag.persetujuan_pemeliharaan.show', $rawat->id) }}" title="Detail" class="w-10 h-10 inline-flex items-center justify-center text-sky-600 hover:text-sky-900 bg-sky-50 rounded-xl hover:bg-sky-100 transition-colors shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $tab === 'riwayat' ? 6 : 5 }}" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data {{ $tab === 'pending' ? 'yang menunggu persetujuan.' : 'riwayat pemeliharaan.' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $pemeliharaans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
