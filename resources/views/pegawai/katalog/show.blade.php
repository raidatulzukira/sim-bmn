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
                <!-- Detail Informasi -->
                <div class="w-full p-6">
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
