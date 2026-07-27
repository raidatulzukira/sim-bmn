@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Laporkan Kerusakan Aset') }}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <!-- Decorative Top -->
                <div class="h-4 w-full bg-gradient-to-r from-sky-400 to-blue-500"></div>

                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center shrink-0 border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Form Laporan Kerusakan</h3>
                            <p class="text-sm text-slate-500 mt-1">Silakan isi detail kendala atau kerusakan aset yang Anda temui.</p>
                        </div>
                    </div>
                
                    @if($asets->count() == 0)
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-amber-800 mb-2">Semua Aset Tersedia atau Sedang Diservis</h4>
                            <p class="text-amber-700 max-w-md">Tidak ada aset BMN yang dapat dilaporkan kerusakannya saat ini (semua aset dalam kondisi baik atau sedang dalam proses perbaikan).</p>
                        </div>
                    @else
                        <form action="{{ route('pegawai.laporan_kerusakan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Pilih Aset -->
                            <div>
                                <label for="aset_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset yang Rusak <span class="text-sky-500">*</span></label>
                                <div class="relative">
                                    <select id="aset_id" name="aset_id" class="block w-full pl-4 pr-10 py-3 text-base border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required autofocus>
                                        <option value="">-- Pilih Aset --</option>
                                        @foreach($asets as $aset)
                                            <option value="{{ $aset->id }}" {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                                {{ $aset->kode_barang }} - {{ $aset->nama_barang }} ({{ $aset->jenis_bmn }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Hanya aset yang tidak sedang diservis yang akan muncul di daftar ini.</p>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi_kerusakan" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Kerusakan / Kendala <span class="text-sky-500">*</span></label>
                                <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="5" class="block w-full p-4 border-slate-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-xl transition-colors bg-slate-50 hover:bg-white" required placeholder="Jelaskan kendala atau kerusakan yang terjadi secara detail...">{{ old('deskripsi_kerusakan') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-2" />
                            </div>

                            <!-- Foto Bukti -->
                            <div>
                                <label for="foto" class="block text-sm font-bold text-slate-700 mb-2">Foto Bukti Kerusakan <span class="text-sky-500">*</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl hover:border-sky-500 hover:bg-sky-50 transition-colors bg-slate-50 group">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-sky-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="foto" class="relative cursor-pointer rounded-md font-bold text-sky-600 hover:text-sky-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sky-500">
                                                <span>Upload file</span>
                                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium">PNG, JPG, JPEG (Max. 2MB)</p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                            </div>

                            <!-- Submit -->
                            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                                <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-3 bg-sky-600 text-white border border-transparent rounded-xl text-sm font-bold hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors shadow-md">
                                    Kirim Laporan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
