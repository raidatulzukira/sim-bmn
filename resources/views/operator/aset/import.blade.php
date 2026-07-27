@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('operator.aset.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Import Data Aset BMN') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-slate-100 pb-6 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Unggah File Data Aset</h3>
                            <p class="text-sm text-slate-500 mt-1">Tambahkan banyak data aset sekaligus melalui file Microsoft Excel atau CSV.</p>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-start gap-3 shadow-sm" role="alert">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="block sm:inline font-medium text-sm">{!! session('error') !!}</span>
                        </div>
                    @endif

                    <div class="mb-8 bg-blue-50 border border-blue-100 text-blue-900 p-6 rounded-2xl text-sm shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <strong class="text-base text-blue-800">Panduan Import:</strong>
                        </div>
                        <ul class="list-disc pl-5 space-y-2 text-blue-800/80">
                            <li>Gunakan file Excel (<code>.xlsx</code>, <code>.xls</code>) atau <code>.csv</code>.</li>
                            <li>Pastikan baris pertama (header) berisi: <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Jenis BMN</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Kode Barang</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">NUP</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Nama Barang</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Merk</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Tipe</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Nama</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Tanggal Perolehan</code>, <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">Nilai Perolehan Pertama</code>.</li>
                            <li>Format Tanggal Perolehan harus disesuaikan agar terbaca oleh sistem (bisa menggunakan format teks <code class="bg-white/60 px-1.5 py-0.5 rounded font-mono text-xs">YYYY-MM-DD</code> atau format Date Excel).</li>
                            <li>Nilai Perolehan Pertama harus berupa angka, hilangkan titik atau koma jika diperlukan.</li>
                            <li>Maksimal ukuran file: <strong>5MB</strong>.</li>
                        </ul>
                    </div>

                    <form action="{{ route('operator.aset.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="file_excel" class="block text-sm font-bold text-slate-700 mb-2">Pilih File Excel/CSV <span class="text-red-500">*</span></label>
                            
                            <div class="mt-1 w-full relative">
                                <input type="file" id="file_excel" name="file_excel" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-3 file:px-6
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-bold
                                    file:bg-emerald-50 file:text-emerald-700
                                    hover:file:bg-emerald-100 file:transition-colors file:cursor-pointer
                                    border border-slate-200 rounded-xl bg-slate-50 cursor-pointer" accept=".xlsx, .xls, .csv" required />
                            </div>
                            @error('file_excel')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('operator.aset.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
