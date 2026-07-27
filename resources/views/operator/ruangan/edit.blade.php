@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('operator.ruangan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Ubah Data Ruangan') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-slate-100 pb-6 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm border border-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Ubah Data Ruangan</h3>
                            <p class="text-sm text-slate-500 mt-1">Lakukan perubahan informasi untuk ruangan <span class="font-bold text-slate-700">{{ $ruangan->nama_ruangan }}</span>.</p>
                        </div>
                    </div>

                    <form action="{{ route('operator.ruangan.update', $ruangan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="nama_ruangan" class="block text-sm font-bold text-slate-700 mb-2">Nama Ruangan <span class="text-red-500">*</span></label>
                            <input id="nama_ruangan" name="nama_ruangan" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required autofocus placeholder="Contoh: Lab Komputer 1" />
                            @error('nama_ruangan')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-2">Keterangan <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                            <textarea id="keterangan" name="keterangan" rows="4" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" placeholder="Tambahkan deskripsi atau lokasi spesifik ruangan...">{{ old('keterangan', $ruangan->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('operator.ruangan.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
