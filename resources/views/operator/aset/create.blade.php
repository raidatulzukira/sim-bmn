@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('operator.aset.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Tambah Data Aset Baru') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-slate-100 pb-6">
                        <h3 class="text-lg font-bold text-slate-800">Informasi Aset BMN</h3>
                        <p class="text-sm text-slate-500 mt-1">Lengkapi data di bawah ini untuk menambahkan aset Barang Milik Negara (BMN) baru.</p>
                    </div>

                    <form action="{{ route('operator.aset.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Barang -->
                            <div>
                                <label for="kode_barang" class="block text-sm font-bold text-slate-700 mb-2">Kode Barang <span class="text-red-500">*</span></label>
                                <input id="kode_barang" name="kode_barang" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('kode_barang') }}" required autofocus placeholder="Contoh: 3050206074" />
                                @error('kode_barang')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NUP -->
                            <div>
                                <label for="nup" class="block text-sm font-bold text-slate-700 mb-2">Nomor Urut Pendaftaran (NUP)</label>
                                <input id="nup" name="nup" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nup') }}" placeholder="Contoh: 1, 2, 3..." />
                                @error('nup')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang -->
                            <div class="md:col-span-2">
                                <label for="nama_barang" class="block text-sm font-bold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                                <input id="nama_barang" name="nama_barang" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nama_barang') }}" required placeholder="Masukkan nama barang" />
                                @error('nama_barang')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis BMN -->
                            <div>
                                <label for="jenis_bmn" class="block text-sm font-bold text-slate-700 mb-2">Jenis BMN <span class="text-red-500">*</span></label>
                                <input id="jenis_bmn" name="jenis_bmn" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('jenis_bmn') }}" required placeholder="Contoh: MESIN PERALATAN TIK" />
                                @error('jenis_bmn')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Merk -->
                            <div>
                                <label for="merk" class="block text-sm font-bold text-slate-700 mb-2">Merk <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="merk" name="merk" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('merk') }}" placeholder="Masukkan merk" />
                                @error('merk')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe -->
                            <div>
                                <label for="tipe" class="block text-sm font-bold text-slate-700 mb-2">Tipe <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="tipe" name="tipe" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('tipe') }}" placeholder="Masukkan tipe" />
                                @error('tipe')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Nama Spesifik -->
                            <div>
                                <label for="nama" class="block text-sm font-bold text-slate-700 mb-2">Nama Spesifik <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="nama" name="nama" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nama') }}" placeholder="Nama spesifik/alias aset" />
                                @error('nama')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Perolehan -->
                            <div>
                                <label for="tanggal_perolehan" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Perolehan <span class="text-red-500">*</span></label>
                                <input id="tanggal_perolehan" name="tanggal_perolehan" type="date" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('tanggal_perolehan') }}" required />
                                @error('tanggal_perolehan')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nilai Perolehan Pertama -->
                            <div>
                                <label for="nilai_perolehan_pertama" class="block text-sm font-bold text-slate-700 mb-2">Nilai Perolehan Pertama (Rp) <span class="text-red-500">*</span></label>
                                <input id="nilai_perolehan_pertama" name="nilai_perolehan_pertama" type="number" step="0.01" min="0" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nilai_perolehan_pertama') }}" required placeholder="Contoh: 15000000" />
                                @error('nilai_perolehan_pertama')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ruangan -->
                            <div class="md:col-span-2">
                                <label for="ruangan_id" class="block text-sm font-bold text-slate-700 mb-2">Ruangan Penyimpanan <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <select id="ruangan_id" name="ruangan_id" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3">
                                    <option value="">-- Pilih Ruangan (Boleh Kosong) --</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruangan_id')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 mb-4 border-b border-slate-100 pb-2">
                            <h4 class="text-md font-bold text-slate-800">Pemeliharaan & Status</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Interval Servis -->
                            <div>
                                <label for="interval_servis_tahun" class="block text-sm font-bold text-slate-700 mb-2">Interval Servis Rutin <span class="text-slate-400 font-normal ml-1">(Tahun)</span></label>
                                <input id="interval_servis_tahun" name="interval_servis_tahun" type="number" min="1" max="20" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('interval_servis_tahun') }}" placeholder="Contoh: 1 atau 5" />
                                <p class="text-xs text-slate-500 mt-2">Isi jika aset ini membutuhkan pemeliharaan/servis rutin secara berkala.</p>
                                @error('interval_servis_tahun')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Tanggal Servis Terakhir -->
                            <div>
                                <label for="tanggal_servis_terakhir" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Servis Terakhir</label>
                                <input id="tanggal_servis_terakhir" name="tanggal_servis_terakhir" type="date" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('tanggal_servis_terakhir') }}" />
                                @error('tanggal_servis_terakhir')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status Aset <span class="text-red-500">*</span></label>
                                <select id="status" name="status" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" required>
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Siap Digunakan)</option>
                                    <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="servis" {{ old('status') == 'servis' ? 'selected' : '' }}>Servis (Pemeliharaan)</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('operator.aset.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Aset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
