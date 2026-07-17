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
                            <x-input-label for="kode_barang" value="Kode Aset *" />
                            <x-text-input id="kode_barang" name="kode_barang" type="text" class="mt-1 block w-full" :value="old('kode_barang', $aset->kode_barang)" required autofocus />
                            <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nama_barang" value="Nama Aset *" />
                            <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full" :value="old('nama_barang', $aset->nama_barang)" required />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="jenis_bmn" value="Jenis BMN *" />
                            <x-text-input id="jenis_bmn" name="jenis_bmn" type="text" class="mt-1 block w-full" :value="old('jenis_bmn', $aset->jenis_bmn)" required />
                            <x-input-error :messages="$errors->get('jenis_bmn')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nup" value="NUP" />
                            <x-text-input id="nup" name="nup" type="text" class="mt-1 block w-full" :value="old('nup', $aset->nup)" />
                            <x-input-error :messages="$errors->get('nup')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="merk" value="Merk" />
                            <x-text-input id="merk" name="merk" type="text" class="mt-1 block w-full" :value="old('merk', $aset->merk)" />
                            <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tipe" value="Tipe" />
                            <x-text-input id="tipe" name="tipe" type="text" class="mt-1 block w-full" :value="old('tipe', $aset->tipe)" />
                            <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nama" value="Nama" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $aset->nama)" />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_perolehan" value="Tanggal Perolehan *" />
                            <x-text-input id="tanggal_perolehan" name="tanggal_perolehan" type="date" class="mt-1 block w-full" :value="old('tanggal_perolehan', optional($aset->tanggal_perolehan)->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_perolehan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nilai_perolehan_pertama" value="Nilai Perolehan Pertama *" />
                            <x-text-input id="nilai_perolehan_pertama" name="nilai_perolehan_pertama" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('nilai_perolehan_pertama', $aset->nilai_perolehan_pertama)" required />
                            <x-input-error :messages="$errors->get('nilai_perolehan_pertama')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="ruangan_id" value="Ruangan" />
                            <select id="ruangan_id" name="ruangan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Boleh Kosong --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ old('ruangan_id', $aset->ruangan_id) == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('ruangan_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="mb-4">
                            <x-input-label for="interval_servis_tahun" value="Interval Servis Rutin (Tahun)" />
                            <x-text-input id="interval_servis_tahun" name="interval_servis_tahun" type="number" min="1" max="20" class="mt-1 block w-full" :value="old('interval_servis_tahun', $aset->interval_servis_tahun)" placeholder="Opsional (misal: 1 atau 5)" />
                            <p class="text-xs text-gray-500 mt-1">Isi jika aset ini membutuhkan pemeliharaan rutin.</p>
                            <x-input-error :messages="$errors->get('interval_servis_tahun')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="tanggal_servis_terakhir" value="Tanggal Servis Terakhir" />
                            <x-text-input id="tanggal_servis_terakhir" name="tanggal_servis_terakhir" type="date" class="mt-1 block w-full" :value="old('tanggal_servis_terakhir', optional($aset->tanggal_servis_terakhir)->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('tanggal_servis_terakhir')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
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
