@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('operator.pengguna.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-slate-100 pb-6 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg shadow-sm border border-blue-200">
                            {{ strtoupper(substr($pengguna->email, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Ubah Data Pengguna</h3>
                            <p class="text-sm text-slate-500 mt-1">Lakukan perubahan data untuk pengguna <span class="font-bold text-slate-700">{{ $pengguna->name }}</span>.</p>
                        </div>
                    </div>

                    <form action="{{ route('operator.pengguna.update', $pengguna->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input id="name" name="name" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('name', $pengguna->name) }}" required autofocus placeholder="Masukkan nama lengkap" />
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('email', $pengguna->email) }}" required placeholder="email@bdi.id" />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password Baru <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="password" name="password" type="password" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" placeholder="Kosongkan jika tidak diubah" />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="md:col-span-2">
                                <label for="role" class="block text-sm font-bold text-slate-700 mb-2">Peran (Role) <span class="text-red-500">*</span></label>
                                <select id="role" name="role" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" required>
                                    <option value="operator" {{ old('role', $pengguna->role) == 'operator' ? 'selected' : '' }}>Operator System</option>
                                    <option value="kasubag_tu" {{ old('role', $pengguna->role) == 'kasubag_tu' ? 'selected' : '' }}>Kepala Sub Bagian Tata Usaha (Kasubag TU)</option>
                                    <option value="pegawai" {{ old('role', $pengguna->role) == 'pegawai' ? 'selected' : '' }}>Pegawai / Staf</option>
                                </select>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIP -->
                            <div>
                                <label for="nip" class="block text-sm font-bold text-slate-700 mb-2">NIP <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="nip" name="nip" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('nip', $pengguna->nip) }}" placeholder="Nomor Induk Pegawai" />
                                @error('nip')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No WA -->
                            <div>
                                <label for="no_wa" class="block text-sm font-bold text-slate-700 mb-2">No WhatsApp <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <input id="no_wa" name="no_wa" type="text" class="block w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" value="{{ old('no_wa', $pengguna->no_wa) }}" placeholder="Contoh: 08123456789" />
                                @error('no_wa')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('operator.pengguna.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-200">
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
