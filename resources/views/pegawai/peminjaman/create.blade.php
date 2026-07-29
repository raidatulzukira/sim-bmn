@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('pegawai.peminjaman.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Ajukan Peminjaman Aset BMN') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <!-- Decorative Top -->
                <div class="h-4 w-full bg-gradient-to-r from-sky-400 to-blue-500"></div>

                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Form Pengajuan Peminjaman</h3>
                            <p class="text-sm text-slate-500 mt-1">Silakan isi detail aset yang ingin Anda pinjam beserta tanggal dan keperluannya.</p>
                        </div>
                    </div>
                
                    @if($asets->count() == 0)
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-amber-800 mb-2">Semua Aset Sedang Dipinjam atau Tidak Tersedia</h4>
                            <p class="text-amber-700 max-w-md">Saat ini tidak ada aset BMN dengan status 'Tersedia' yang dapat dipinjam.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('pegawai.peminjaman.store') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Pilih Aset -->
                            <div>
                                <label for="aset_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset BMN <span class="text-sky-500">*</span></label>
                                <div class="relative">
                                    <select id="aset_id" name="aset_id" class="block w-full pl-4 pr-10 py-3 text-base border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required autofocus>
                                        <option value="" disabled {{ empty(old('aset_id', $selectedAset ?? '')) ? 'selected' : '' }}>-- Pilih Aset yang Tersedia --</option>
                                        @foreach($asets as $aset)
                                            <option value="{{ $aset->id }}" {{ old('aset_id', $selectedAset ?? '') == $aset->id ? 'selected' : '' }}>
                                                [{{ $aset->kode_barang }}] {{ $aset->nama_barang }} - {{ $aset->merk ?? 'Tanpa Merk' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Hanya menampilkan aset dengan status Tersedia.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Estimasi Waktu Pinjam -->
                                <div>
                                    <label for="estimasi_waktu_pinjam" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pinjam (Estimasi) <span class="text-sky-500">*</span></label>
                                    <input type="date" id="estimasi_waktu_pinjam" name="estimasi_waktu_pinjam" value="{{ old('estimasi_waktu_pinjam') }}" min="{{ date('Y-m-d') }}" class="block w-full px-4 py-3 border-slate-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required>
                                    <x-input-error :messages="$errors->get('estimasi_waktu_pinjam')" class="mt-2" />
                                </div>

                                <!-- Tanggal Kembali Rencana -->
                                <div>
                                    <label for="tanggal_kembali_rencana" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kembali (Rencana) <span class="text-sky-500">*</span></label>
                                    <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana') }}" min="{{ date('Y-m-d') }}" class="block w-full px-4 py-3 border-slate-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required>
                                    <x-input-error :messages="$errors->get('tanggal_kembali_rencana')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div>
                                <label for="keperluan" class="block text-sm font-bold text-slate-700 mb-2">Keperluan Pinjam <span class="text-sky-500">*</span></label>
                                <textarea id="keperluan" name="keperluan" rows="4" class="block w-full p-4 border-slate-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required placeholder="Jelaskan secara rinci untuk keperluan apa aset ini dipinjam...">{{ old('keperluan') }}</textarea>
                                <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
                            </div>

                            <!-- Submit -->
                            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                                <a href="{{ route('pegawai.peminjaman.index') }}" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-3 bg-sky-600 text-white border border-transparent rounded-xl text-sm font-bold hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors shadow-md">
                                    Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
