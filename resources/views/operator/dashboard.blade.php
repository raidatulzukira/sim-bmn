@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        {{ __('Dashboard Operator') }}
    </h2>
@endsection

@section('content')
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Aset -->
                <div class="bg-white overflow-hidden rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Aset BMN</div>
                    </div>
                    <div class="text-4xl font-extrabold text-slate-800">{{ $totalAset }}</div>
                </div>

                <!-- Aset Dipinjam -->
                <div class="bg-white overflow-hidden rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Aset Dipinjam</div>
                    </div>
                    <div class="text-4xl font-extrabold text-slate-800">{{ $asetDipinjam }}</div>
                </div>

                <!-- Aset Servis -->
                <div class="bg-white overflow-hidden rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Aset Dalam Servis</div>
                    </div>
                    <div class="text-4xl font-extrabold text-slate-800">{{ $asetServis }}</div>
                </div>
            </div>

            <!-- Alerts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Peminjaman Jatuh Tempo -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100 flex flex-col">
                    <div class="p-6 bg-white border-b border-slate-100 flex-none">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Peminjaman Mendekati Jatuh Tempo
                        </h3>
                    </div>
                    
                    <div class="p-6 flex-grow">
                        @if($alertPeminjaman->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Peminjam</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Rencana Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @foreach($alertPeminjaman as $pinjam)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-slate-700">{{ $pinjam->user->name }}</td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">{{ $pinjam->asetBmn->nama_barang }}</td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm">
                                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 font-bold rounded-full">
                                                        {{ $pinjam->tanggal_kembali_rencana->format('d M Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-8">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Tidak ada peminjaman yang mendekati jatuh tempo (H-2).</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pemeliharaan Pending -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100 flex flex-col">
                    <div class="p-6 bg-white border-b border-slate-100 flex-none">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </span>
                            Pemeliharaan Perlu Tindakan
                        </h3>
                    </div>
                    
                    <div class="p-6 flex-grow">
                        @if($alertPemeliharaan->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @foreach($alertPemeliharaan as $rawat)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-slate-700">{{ $rawat->asetBmn->nama_barang }}</td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600 capitalize">{{ $rawat->jenis }}</td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $rawat->status == 'pending' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800' }}">
                                                        {{ ucfirst($rawat->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-8">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Tidak ada jadwal pemeliharaan yang berstatus pending atau proses.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Servis Rutin Jatuh Tempo -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100 lg:col-span-2">
                    <div class="p-6 bg-white border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            Jadwal Servis Rutin Aset (H-30 / Melewati Jadwal)
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($asetMembutuhkanServis->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aset BMN</th>
                                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Servis Terakhir</th>
                                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jadwal Servis Berikutnya</th>
                                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @foreach($asetMembutuhkanServis as $aset)
                                            <tr class="hover:bg-slate-50 transition-colors bg-rose-50/30">
                                                <td class="px-5 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-slate-800">{{ $aset->nama_barang }}</div>
                                                    <div class="text-xs text-slate-500">{{ $aset->kode_barang }}</div>
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">
                                                    {{ $aset->tanggal_servis_terakhir->format('d M Y') }}
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 font-bold rounded-full text-sm flex inline-flex items-center gap-1.5">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                                        {{ $aset->jadwal_servis_berikutnya->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-sm">
                                                    <a href="{{ route('operator.pemeliharaan.create', ['aset_id' => $aset->id]) }}" 
                                                       class="inline-flex items-center gap-1 px-4 py-2 bg-sky-700 text-white font-semibold rounded-lg hover:bg-sky-800 transition-colors shadow-sm hover:shadow shadow-blue-600/20">
                                                        Ajukan Servis
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center py-8">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Kondisi aman. Saat ini tidak ada aset yang jadwal servis rutinnya mendekati (H-30) atau terlewat.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
