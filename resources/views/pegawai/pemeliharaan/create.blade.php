<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporkan Kerusakan Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-red-500">
                
                @if($asets->count() == 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <p class="text-sm text-yellow-700">Tidak ada aset BMN yang dapat dilaporkan kerusakannya saat ini (semua aset mungkin sedang dalam perbaikan).</p>
                    </div>
                @else
                    <form action="{{ route('pegawai.laporan_kerusakan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="aset_id" value="Pilih Aset yang Rusak *" />
                            <select id="aset_id" name="aset_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}" {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                        {{ $aset->kode_aset }} - {{ $aset->nama_aset }} ({{ $aset->kategori }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Hanya aset yang tidak sedang diservis yang akan muncul.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi_kerusakan" value="Deskripsi Kerusakan / Kendala *" />
                            <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Jelaskan kendala atau kerusakan yang terjadi secara detail...">{{ old('deskripsi_kerusakan') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
                            <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
