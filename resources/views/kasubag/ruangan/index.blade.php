@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            {{ __('Data Ruangan') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter & Search -->
            <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100">
                <form method="GET" action="{{ route('kasubag.ruangan.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="search" class="block text-sm font-bold text-slate-700 mb-2">Pencarian Ruangan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="pl-10 block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200" placeholder="Cari nama ruangan..." />
                        </div>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-colors duration-300 shadow-sm flex items-center justify-center gap-2">
                            Cari
                        </button>
                        <a href="{{ route('kasubag.ruangan.index') }}" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center text-center">
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
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Ruangan</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Jumlah Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($ruangans as $index => $ruangan)
                                <tr class="hover:bg-sky-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500 font-medium">{{ ($ruangans->currentPage() - 1) * $ruangans->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            </div>
                                            {{ $ruangan->nama_ruangan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            {{ $ruangan->aset_bmn_count }} Aset
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-left text-sm text-slate-500 max-w-xs truncate">{{ $ruangan->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data ruangan yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $ruangans->links() }}
            </div>

        </div>
    </div>
@endsection
