<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Katalog Aset BMN') }}
            </h2>
            <a href="{{ route('pegawai.katalog_aset.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row">
                <!-- Foto Aset -->
                <div class="md:w-1/3 bg-gray-100 p-4 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                    @if($katalog_aset->foto)
                        <img src="{{ asset('storage/' . $katalog_aset->foto) }}" alt="{{ $katalog_aset->nama_barang }}" class="w-full h-auto rounded-md shadow-sm">
                    @else
                        <div class="text-gray-400 text-center py-12">
                            <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p>Tidak ada foto</p>
                        </div>
                    @endif
                </div>

                <!-- Detail Informasi -->
                <div class="md:w-2/3 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $katalog_aset->nama_barang }}</h3>
                            <p class="text-sm text-gray-500">{{ $katalog_aset->merk ?? 'Tanpa Merk' }} {{ $katalog_aset->tipe ? ' - ' . $katalog_aset->tipe : '' }}</p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            {{ $katalog_aset->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($katalog_aset->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($katalog_aset->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Kode Barang</h4>
                            <p class="text-base text-gray-900">{{ $katalog_aset->kode_barang }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">NUP</h4>
                            <p class="text-base text-gray-900">{{ $katalog_aset->nup ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Jenis BMN</h4>
                            <p class="text-base text-gray-900">{{ $katalog_aset->jenis_bmn }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Lokasi Ruangan</h4>
                            <p class="text-base text-gray-900">{{ $katalog_aset->ruangan ? $katalog_aset->ruangan->nama_ruangan : '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Perolehan</h4>
                            <p class="text-base text-gray-900">{{ $katalog_aset->tanggal_perolehan ? \Carbon\Carbon::parse($katalog_aset->tanggal_perolehan)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Nilai Perolehan Pertama</h4>
                            <p class="text-base text-gray-900">Rp {{ number_format($katalog_aset->nilai_perolehan_pertama, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($katalog_aset->status === 'tersedia')
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('pegawai.peminjaman.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Ajukan Peminjaman
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
