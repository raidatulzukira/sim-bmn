@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Kelola Pemeliharaan Aset') }}
        </h2>
        <!-- <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('operator.pemeliharaan.create') }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Servis Rutin
            </a>
        </div> -->
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 mb-6">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100">
                <form method="GET" action="{{ route('operator.pemeliharaan.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="jenis" class="block text-sm font-bold text-slate-700 mb-2">Jenis Pemeliharaan</label>
                        <select name="jenis" id="jenis" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-colors duration-200 bg-white px-4 py-3">
                            <option value="">Semua Jenis</option>
                            <option value="rutin" {{ request('jenis') == 'rutin' ? 'selected' : '' }}>Rutin (Jadwal)</option>
                            <option value="situasional" {{ request('jenis') == 'situasional' ? 'selected' : '' }}>Situasional (Laporan)</option>
                        </select>
                    </div>
                    <div class="flex-1 w-full">
                        <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status Pemeliharaan</label>
                        <select name="status" id="status" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-colors duration-200 bg-white px-4 py-3">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui (Siap Servis)</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto mt-4 md:mt-0">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-colors duration-300 shadow-sm flex items-center justify-center gap-2">
                            Filter
                        </button>
                        <a href="{{ route('operator.pemeliharaan.index') }}" class="w-full sm:w-auto px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center text-center">
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
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">No. Nota</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($pemeliharaans as $rawat)
                                <tr class="hover:bg-sky-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                        {{ $rawat->batch_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm">
                                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <div>
                                                @if($rawat->asetBmn)
                                                    {{ $rawat->asetBmn->nama_barang }}
                                                    @if(isset($rawat->total_barang) && $rawat->total_barang > 1)
                                                        <span class="inline-flex items-center justify-center px-2 py-0.5 ml-2 text-xs font-bold text-sky-700 bg-sky-100 rounded-full border border-sky-200">
                                                            {{ $rawat->total_barang }} Unit
                                                        </span>
                                                    @endif
                                                    <span class="block text-xs font-mono font-medium text-slate-400 mt-0.5">{{ $rawat->asetBmn->kode_barang }}</span>
                                                @else
                                                    <span class="text-rose-600 italic">Menunggu Tinjauan</span>
                                                    <span class="block text-xs font-mono font-medium text-slate-400 mt-0.5">Dilaporkan oleh Pegawai</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600">
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full {{ $rawat->jenis === 'rutin' ? 'bg-slate-100 text-slate-700 border border-slate-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                            {{ ucfirst($rawat->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-500 font-medium">{{ $rawat->tanggal_pengajuan->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        @php
                                            $color = match($rawat->status) {
                                                'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                                'disetujui' => 'bg-sky-50 border-sky-200 text-sky-700',
                                                'proses' => 'bg-orange-50 border-orange-200 text-orange-700',
                                                'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                                'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                                default => 'bg-slate-50 border-slate-200 text-slate-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $color }}">
                                            {{ $rawat->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <div class="flex justify-start gap-2 items-center transition-opacity duration-200">
                                            @if($rawat->status === 'disetujui')
                                                <a href="{{ route('operator.pemeliharaan.show', $rawat->id) }}" class="inline-flex items-center justify-center text-sky-700 hover:text-sky-900 bg-sky-100 px-4 py-2 rounded-lg hover:bg-sky-200 transition-colors font-bold shadow-sm gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Mulai Servis
                                                </a>
                                            @elseif($rawat->status === 'proses')
                                                <a href="{{ route('operator.pemeliharaan.show', $rawat->id) }}" class="inline-flex items-center justify-center text-orange-700 hover:text-orange-900 bg-orange-100 px-4 py-2 rounded-lg hover:bg-orange-200 transition-colors font-bold shadow-sm gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Selesaikan
                                                </a>
                                            @else
                                                <a href="{{ route('operator.pemeliharaan.show', $rawat->id) }}" title="Detail" class="w-10 h-10 inline-flex items-center justify-center text-yellow-600 hover:text-yellow-900 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data pemeliharaan yang ditemukan.</p>
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
