<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Aset Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($asets->count() == 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">Saat ini tidak ada aset BMN yang berstatus <strong>Tersedia</strong> untuk dipinjam.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{ route('pegawai.peminjaman.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="aset_id" value="Pilih Aset *" />
                            <select id="aset_id" name="aset_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}" {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                        {{ $aset->kode_aset }} - {{ $aset->nama_aset }} ({{ $aset->kategori }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Hanya aset dengan status tersedia yang ditampilkan di sini.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <x-input-label for="estimasi_waktu_pinjam" value="Mulai Pinjam (Tanggal) *" />
                                <x-text-input id="estimasi_waktu_pinjam" name="estimasi_waktu_pinjam" type="date" class="mt-1 block w-full" :value="old('estimasi_waktu_pinjam')" required />
                                <x-input-error :messages="$errors->get('estimasi_waktu_pinjam')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="tanggal_kembali_rencana" value="Rencana Kembali (Tanggal) *" />
                                <x-text-input id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" type="date" class="mt-1 block w-full" :value="old('tanggal_kembali_rencana')" required />
                                <x-input-error :messages="$errors->get('tanggal_kembali_rencana')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="keperluan" value="Keperluan Peminjaman *" />
                            <textarea id="keperluan" name="keperluan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Jelaskan secara detail untuk keperluan apa aset ini dipinjam...">{{ old('keperluan') }}</textarea>
                            <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pegawai.peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <x-primary-button>
                                Ajukan Peminjaman
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
