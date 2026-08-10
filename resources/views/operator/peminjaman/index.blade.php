@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ __('Kelola Peminjaman Aset') }}
        </h2>
    </div>
@endsection

@section('content')
    <style>
        @keyframes pulse-red-soft {
            0%, 100% { background-color: transparent; }
            50% { background-color: #fee2e2; border-color: #fca5a5; } /* bg-red-100 border-red-300 */
        }
        .animate-pulse-red-soft {
            animation: pulse-red-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter & Search -->
            <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100">
                <form method="GET" action="{{ route('operator.peminjaman.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Filter Berdasarkan Status</label>
                        <select name="status" id="status" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-white px-4 py-3">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu TU)</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui (Siap Diserahkan)</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-colors duration-300 shadow-sm flex items-center justify-center gap-2">
                            Filter Data
                        </button>
                        <a href="{{ route('operator.peminjaman.index') }}" class="w-full sm:w-auto px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center text-center">
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
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($peminjamans as $pinjam)
                                @php
                                    $isWarning = false;
                                    if ($pinjam->status === 'dipinjam' && $pinjam->tanggal_kembali_rencana) {
                                        $daysDiff = now()->startOfDay()->diffInDays($pinjam->tanggal_kembali_rencana->startOfDay(), false);
                                        if ($daysDiff <= 1) {
                                            $isWarning = true;
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-sky-50/50 transition-colors duration-200 group {{ $isWarning ? 'animate-pulse-red-soft border-l-4 border-l-red-500' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-bold text-slate-900">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($pinjam->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                {{ $pinjam->user->name }}
                                                @if($isWarning)
                                                    <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded text-xs font-bold bg-red-600 text-white animate-pulse shadow-sm">
                                                        Segera Kembali!
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-600 font-medium">
                                        {{ $pinjam->asetBmn->nama_barang ?? '-' }} <span class="text-xs text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full ml-1">({{ $pinjam->total_barang }} Unit)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm text-slate-500 font-medium">{{ $pinjam->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        @php
                                            $color = match($pinjam->status) {
                                                'pending' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                                'disetujui' => 'bg-blue-50 border-blue-200 text-blue-700',
                                                'dipinjam' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                                'dikembalikan' => 'bg-slate-100 border-slate-300 text-slate-700',
                                                'ditolak' => 'bg-red-50 border-red-200 text-red-700',
                                                default => 'bg-slate-50 border-slate-200 text-slate-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $color }}">
                                            {{ $pinjam->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <div class="flex justify-start gap-2 items-center transition-opacity duration-200">
                                            @if($pinjam->status === 'disetujui')
                                                <a href="{{ route('operator.peminjaman.show', $pinjam->id) }}" class="inline-flex items-center justify-center text-blue-700 hover:text-blue-900 bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200 transition-colors font-bold shadow-sm gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    Serahkan Aset
                                                </a>
                                            @elseif($pinjam->status === 'dipinjam')
                                                <a href="{{ route('operator.peminjaman.show', $pinjam->id) }}" class="inline-flex items-center justify-center text-emerald-700 hover:text-emerald-900 bg-emerald-100 px-4 py-2 rounded-lg hover:bg-emerald-200 transition-colors font-bold shadow-sm gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Konfirmasi Kembali
                                                </a>
                                            @else
                                                <a href="{{ route('operator.peminjaman.show', $pinjam->id) }}" title="Detail" class="w-10 h-10 inline-flex items-center justify-center text-yellow-600 hover:text-yellow-900 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors shadow-sm">
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
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data peminjaman yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $peminjamans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
