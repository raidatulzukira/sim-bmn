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
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-8 border-b border-slate-100 gap-4">
                        <div class="flex items-center gap-5">
                            <div class="h-16 w-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-2xl shadow-sm border border-blue-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $aset->nama_barang }}</h3>
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-sm font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">{{ $aset->kode_barang }}</span>
                                    <span class="text-sm font-medium text-slate-400">{{ $aset->jenis_bmn }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="px-4 py-2 inline-flex text-sm font-bold rounded-full border 
                                {{ $aset->status === 'tersedia' ? 'bg-green-50 border-green-200 text-green-700' : ($aset->status === 'dipinjam' ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : 'bg-red-50 border-red-200 text-red-700') }}">
                                {{ $aset->status === 'dipinjam' ? 'Sedang Dipinjam' : ucfirst($aset->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-8 gap-x-6">
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">NUP</span>
                            <span class="block text-base font-medium text-slate-900">{{ $aset->nup ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">Merk / Tipe</span>
                            <span class="block text-base font-medium text-slate-900">{{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">Nama (Alias)</span>
                            <span class="block text-base font-medium text-slate-900">{{ $aset->nama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">Tanggal Perolehan</span>
                            <span class="block text-base font-medium text-slate-900">{{ \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">Nilai Perolehan Pertama</span>
                            <span class="block text-base font-medium text-slate-900 font-mono">Rp {{ number_format($aset->nilai_perolehan_pertama, 2, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-400 mb-1">Lokasi Ruangan</span>
                            <span class="block text-base font-medium text-slate-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}
                            </span>
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
