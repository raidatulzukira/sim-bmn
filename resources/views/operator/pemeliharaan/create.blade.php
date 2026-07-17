<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Jadwal Servis Rutin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($asets->count() == 0)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <p class="text-sm text-yellow-700">Saat ini tidak ada aset BMN berstatus tersedia yang bisa diajukan servisnya.</p>
                    </div>
                @else
                    <form action="{{ route('operator.pemeliharaan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="aset_id" value="Pilih Aset *" />
                            <select id="aset_id" name="aset_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}" {{ old('aset_id', request('aset_id')) == $aset->id ? 'selected' : '' }}>
                                        {{ $aset->kode_barang }} - {{ $aset->nama_barang }} ({{ $aset->jenis_bmn }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('aset_id')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Hanya aset dengan status tersedia yang muncul (aset yang dipinjam atau sedang diservis tidak dapat didaftarkan).</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi_kerusakan" value="Catatan / Area Servis (Opsional)" />
                            <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Misal: Ganti oli rutin, pembersihan kipas, dll...">{{ old('deskripsi_kerusakan') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('operator.pemeliharaan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <x-primary-button>
                                Ajukan Servis Rutin
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
