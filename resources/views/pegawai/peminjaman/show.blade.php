@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('pegawai.peminjaman.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Detail Peminjaman') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <!-- Header Banner -->
                <div class="relative h-24 bg-gradient-to-r from-sky-600/40 to-sky-700/60">
                    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
                </div>

                <div class="px-8 sm:px-12 pb-12 relative -mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8 border-b border-slate-100 pb-8">
                        <div class="flex items-end gap-5">
                            <div class="w-20 h-20 rounded-2xl bg-white text-sky-500 flex items-center justify-center shadow-lg border-4 border-white shrink-0">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="flex gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold font-mono border border-slate-200">{{ $peminjaman->asetBmn->kode_barang }}</span>
                                    <span class="px-2.5 py-0.5 bg-sky-100 text-sky-700 rounded-lg text-xs font-bold border border-sky-200">{{ isset($batch) ? $batch->count() : 1 }} Unit</span>
                                </div>
                                <h3 class="text-2xl font-extrabold text-slate-900">{{ $peminjaman->asetBmn->nama_barang }}</h3>
                                <p class="text-sm font-medium text-slate-500 mt-1">{{ $peminjaman->asetBmn->merk ?? '-' }} / {{ $peminjaman->asetBmn->tipe ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="mb-2">
                            @php
                                $badge = match($peminjaman->status) {
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'disetujui' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'dipinjam' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                    'dikembalikan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="px-4 py-1.5 inline-flex items-center gap-2 text-xs font-bold rounded-full border shadow-sm {{ $badge }} uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full {{ in_array($peminjaman->status, ['pending', 'dipinjam']) ? 'animate-pulse' : '' }} {{ $peminjaman->status == 'pending' ? 'bg-amber-500' : ($peminjaman->status == 'dipinjam' ? 'bg-indigo-500' : ($peminjaman->status == 'dikembalikan' ? 'bg-emerald-500' : ($peminjaman->status == 'disetujui' ? 'bg-sky-500' : 'bg-slate-500'))) }}"></span>
                                {{ $peminjaman->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        <!-- Kolom Kiri: Informasi -->
                        <div class="space-y-8">
                            <!-- Informasi Peminjam -->
                            <div>
                                <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Informasi Peminjam
                                </h4>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-lg">
                                        {{ substr($peminjaman->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $peminjaman->user->name }}</p>
                                        <p class="text-xs font-medium text-slate-500">Pengaju Peminjaman</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div>
                                <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Keperluan Pinjam
                                </h4>
                                <div class="bg-sky-50/50 p-4 rounded-xl border border-sky-100 text-sm text-slate-800 leading-relaxed font-medium">
                                    {{ $peminjaman->keperluan }}
                                </div>
                            </div>

                            <!-- Catatan Penolakan / Approval -->
                            @if($peminjaman->status === 'ditolak' && $peminjaman->catatan_penolakan)
                                <div>
                                    <h4 class="text-md font-bold text-rose-700 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Alasan Penolakan
                                    </h4>
                                    <div class="bg-rose-50 p-4 rounded-xl border border-rose-200 text-sm text-rose-800 font-medium">
                                        {{ $peminjaman->catatan_penolakan }}
                                    </div>
                                </div>
                            @endif

                            @if(in_array($peminjaman->status, ['disetujui', 'dipinjam', 'dikembalikan']) && $peminjaman->approver)
                                <div>
                                    <h4 class="text-md font-bold text-emerald-700 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Disetujui Oleh
                                    </h4>
                                    <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-200 flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg">
                                            {{ substr($peminjaman->approver->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-emerald-900">{{ $peminjaman->approver->name }}</p>
                                            <p class="text-xs font-medium text-emerald-600">Penyetuju (Kasubag TU / Operator)</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Daftar Aset -->
                            @if(isset($batch) && $batch->count() > 0)
                                <div>
                                    <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        Daftar NUP Aset yang Dipinjam
                                    </h4>
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 max-h-60 overflow-y-auto">
                                        <ul class="space-y-2">
                                            @foreach($batch as $item)
                                                <li class="flex items-center justify-between text-sm">
                                                    <span class="font-mono text-slate-600 font-bold bg-slate-50 px-2 py-1 rounded border border-slate-100">{{ $item->asetBmn->nup }}</span>
                                                    <span class="text-slate-500">{{ $item->asetBmn->ruangan ? $item->asetBmn->ruangan->nama_ruangan : 'Gudang' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: Timeline & Foto -->
                        <div class="space-y-8">
                            <!-- Timeline Peminjaman -->
                            <div>
                                <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Waktu Peminjaman
                                </h4>
                                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Estimasi Pinjam</p>
                                            <p class="text-sm font-bold text-slate-900">{{ $peminjaman->estimasi_waktu_pinjam->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Rencana Kembali</p>
                                            <p class="text-sm font-bold text-slate-900">
                                                {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                                                @if($peminjaman->keterangan_terlambat)
                                                    <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-wider">
                                                        Terlambat {{ $peminjaman->keterangan_terlambat }} Hari
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="h-px w-full bg-slate-200"></div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Aktual Pinjam</p>
                                            @if($peminjaman->tanggal_pinjam)
                                                <p class="text-sm font-bold text-sky-600">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                                                <p class="text-xs font-medium text-slate-500">{{ $peminjaman->tanggal_pinjam->format('H:i') }} WIB</p>
                                            @else
                                                <p class="text-sm font-medium text-slate-400">-</p>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Aktual Kembali</p>
                                            @if($peminjaman->tanggal_kembali_aktual)
                                                <p class="text-sm font-bold text-emerald-600">{{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</p>
                                                <p class="text-xs font-medium text-slate-500">{{ $peminjaman->tanggal_kembali_aktual->format('H:i') }} WIB</p>
                                            @else
                                                <p class="text-sm font-medium text-slate-400">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Foto Dokumentasi -->
                            @if($peminjaman->foto_serah_terima || $peminjaman->foto_pengembalian)
                                <div>
                                    <h4 class="text-md font-bold text-slate-800 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto Dokumentasi
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        @if($peminjaman->foto_serah_terima)
                                            <div class="group relative rounded-xl overflow-hidden shadow-sm border border-slate-200">
                                                <img src="{{ asset('storage/' . $peminjaman->foto_serah_terima) }}" class="w-full aspect-[4/3] object-cover" alt="Foto Serah Terima">
                                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-8">
                                                    <p class="text-white text-xs font-bold text-center">Bukti Serah Terima</p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($peminjaman->foto_pengembalian)
                                            <div class="group relative rounded-xl overflow-hidden shadow-sm border border-slate-200">
                                                <img src="{{ asset('storage/' . $peminjaman->foto_pengembalian) }}" class="w-full aspect-[4/3] object-cover" alt="Foto Pengembalian">
                                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-8">
                                                    <p class="text-white text-xs font-bold text-center">Bukti Pengembalian</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
