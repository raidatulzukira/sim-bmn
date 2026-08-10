@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
        <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        {{ __('Katalog Aset BMN') }}
    </h2>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Section -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Eksplorasi Aset</h3>
                    <p class="text-slate-500 text-sm">Cari dan temukan aset BMN yang tersedia untuk dipinjam.</p>
                </div>

                <!-- Filter & Search -->
                <form method="GET" action="{{ route('pegawai.katalog_aset.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="pl-10 block w-full rounded-xl border-slate-200 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm bg-slate-50" placeholder="Cari kode/nama aset...">
                    </div>
                    
                    <div class="w-full sm:w-48">
                        <select name="jenis_bmn" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm bg-slate-50">
                            <option value="">Semua Jenis BMN</option>
                            <option value="Peralatan dan Mesin" {{ request('jenis_bmn') == 'Peralatan dan Mesin' ? 'selected' : '' }}>Peralatan dan Mesin</option>
                            <option value="Gedung dan Bangunan" {{ request('jenis_bmn') == 'Gedung dan Bangunan' ? 'selected' : '' }}>Gedung dan Bangunan</option>
                            <option value="Aset Tetap Lainnya" {{ request('jenis_bmn') == 'Aset Tetap Lainnya' ? 'selected' : '' }}>Aset Tetap Lainnya</option>
                            <option value="Aset Tak Berwujud" {{ request('jenis_bmn') == 'Aset Tak Berwujud' ? 'selected' : '' }}>Aset Tak Berwujud</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 transition-all duration-300 shadow-sm">
                            Cari
                        </button>
                        <a href="{{ route('pegawai.katalog_aset.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all duration-300">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Kode Barang</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Rentang NUP</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Keterangan Barang</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Jenis BMN</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Informasi Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($asets as $index => $aset)
                                <tr class="hover:bg-sky-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-500 font-medium">{{ ($asets->currentPage() - 1) * $asets->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">{{ $aset->kode_barang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600 font-medium">{{ $aset->nup_awal == $aset->nup_akhir ? $aset->nup_awal : $aset->nup_awal . ' - ' . $aset->nup_akhir }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600 font-medium">
                                        <div class="font-bold text-slate-800">{{ $aset->nama_barang }}</div>
                                        <div class="text-xs text-slate-500">{{ $aset->merk }} {{ $aset->tipe }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600">{{ $aset->jenis_bmn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <div class="flex flex-col gap-1">
                                            <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-slate-100 text-slate-700">Total: {{ $aset->total_stok }}</span>
                                            <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-green-50 text-green-700">Tersedia: {{ $aset->stok_tersedia }}</span>
                                            @if($aset->stok_dipinjam > 0)
                                                <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-indigo-50 text-indigo-700">Dipinjam: {{ $aset->stok_dipinjam }}</span>
                                            @endif
                                            @if($aset->stok_menunggu_persetujuan > 0)
                                                <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-amber-50 text-amber-700">Menunggu Persetujuan: {{ $aset->stok_menunggu_persetujuan }}</span>
                                            @endif
                                            @if($aset->stok_menunggu_serah_terima > 0)
                                                <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-sky-50 text-sky-700">Menunggu Serah Terima: {{ $aset->stok_menunggu_serah_terima }}</span>
                                            @endif
                                            @if($aset->stok_menunggu_servis > 0)
                                                <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-orange-50 text-orange-700">Menunggu Servis: {{ $aset->stok_menunggu_servis }}</span>
                                            @endif
                                            @if($aset->stok_servis > 0)
                                                <span class="px-2 py-0.5 inline-flex text-xs font-bold rounded-full bg-red-50 text-red-700">Servis: {{ $aset->stok_servis }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <div class="flex justify-start gap-2 items-center">
                                            <a href="{{ route('pegawai.katalog_aset.show', $aset->id) }}" title="Lihat Detail" class="w-10 h-10 inline-flex items-center justify-center text-sky-600 hover:text-sky-900 bg-sky-50 rounded-lg hover:bg-sky-100 transition-colors shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data aset BMN yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $asets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
