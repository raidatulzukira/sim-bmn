<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('operator.aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <x-input-label for="kode_aset" value="Kode Aset *" />
                            <x-text-input id="kode_aset" name="kode_aset" type="text" class="mt-1 block w-full" :value="old('kode_aset', $aset->kode_aset)" required autofocus />
                            <x-input-error :messages="$errors->get('kode_aset')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nama_aset" value="Nama Aset *" />
                            <x-text-input id="nama_aset" name="nama_aset" type="text" class="mt-1 block w-full" :value="old('nama_aset', $aset->nama_aset)" required />
                            <x-input-error :messages="$errors->get('nama_aset')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="kategori" value="Kategori *" />
                            <select id="kategori" name="kategori" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Elektronik" {{ old('kategori', $aset->kategori) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                <option value="Furnitur" {{ old('kategori', $aset->kategori) == 'Furnitur' ? 'selected' : '' }}>Furnitur</option>
                                <option value="Kendaraan" {{ old('kategori', $aset->kategori) == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                <option value="Lainnya" {{ old('kategori', $aset->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="ruangan_id" value="Ruangan *" />
                            <select id="ruangan_id" name="ruangan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ old('ruangan_id', $aset->ruangan_id) == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('ruangan_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="spesifikasi" value="Spesifikasi" />
                        <textarea id="spesifikasi" name="spesifikasi" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('spesifikasi', $aset->spesifikasi) }}</textarea>
                        <x-input-error :messages="$errors->get('spesifikasi')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <x-input-label for="status" value="Status *" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="tersedia" {{ old('status', $aset->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ old('status', $aset->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="servis" {{ old('status', $aset->status) == 'servis' ? 'selected' : '' }}>Servis</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="foto" value="Ganti Foto Aset (Biarkan kosong jika tidak diubah)" />
                            <input type="file" id="foto" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*" />
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                            
                            @if($aset->foto)
                                <div class="mt-2">
                                    <span class="text-sm text-gray-500 block mb-1">Foto saat ini:</span>
                                    <img src="{{ asset('storage/' . $aset->foto) }}" alt="Foto Aset" class="h-24 w-auto rounded-md border border-gray-200">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('operator.aset.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
