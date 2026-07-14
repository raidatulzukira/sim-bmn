<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Aset BMN') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pegawai.peminjaman.store') }}">
                        @csrf

                        <!-- Pilih Aset -->
                        <div class="mb-4">
                            <x-input-label for="aset_id" :value="__('Pilih Aset BMN')" />
                            <select id="aset_id" name="aset_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required autofocus>
                                <option value="" disabled selected>-- Pilih Aset yang Tersedia --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}" {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                        [{{ $aset->kode_barang }}] {{ $aset->nama_barang }} - {{ $aset->merk ?? 'Tanpa Merk' }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Hanya menampilkan aset dengan status Tersedia.</p>
                        </div>

                        <!-- Estimasi Waktu Pinjam -->
                        <div class="mb-4">
                            <x-input-label for="estimasi_waktu_pinjam" :value="__('Tanggal Pinjam (Estimasi)')" />
                            <x-text-input id="estimasi_waktu_pinjam" class="block mt-1 w-full" type="date" name="estimasi_waktu_pinjam" :value="old('estimasi_waktu_pinjam')" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('estimasi_waktu_pinjam')" class="mt-2" />
                        </div>

                        <!-- Tanggal Kembali Rencana -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_kembali_rencana" :value="__('Tanggal Kembali (Rencana)')" />
                            <x-text-input id="tanggal_kembali_rencana" class="block mt-1 w-full" type="date" name="tanggal_kembali_rencana" :value="old('tanggal_kembali_rencana')" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('tanggal_kembali_rencana')" class="mt-2" />
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-4">
                            <x-input-label for="keperluan" :value="__('Keperluan')" />
                            <textarea id="keperluan" name="keperluan" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('keperluan') }}</textarea>
                            <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Jelaskan secara singkat alasan peminjaman aset ini.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pegawai.peminjaman.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
