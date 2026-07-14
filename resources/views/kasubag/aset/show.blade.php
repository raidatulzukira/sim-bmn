<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Aset BMN') }}
            </h2>
            <a href="{{ route('kasubag.aset.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row">
                <!-- Foto Aset -->
                <div class="md:w-1/3 bg-gray-100 p-4 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                    @if($aset->foto)
                        <img src="{{ asset('storage/' . $aset->foto) }}" alt="{{ $aset->nama_barang }}" class="w-full h-auto rounded-md shadow-sm">
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
                            <h3 class="text-2xl font-bold text-gray-900">{{ $aset->nama_barang }}</h3>
                            <p class="text-sm text-gray-500">{{ $aset->merk ?? 'Tanpa Merk' }} {{ $aset->tipe ? ' - ' . $aset->tipe : '' }}</p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            {{ $aset->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($aset->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($aset->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Kode Barang</h4>
                            <p class="text-base text-gray-900">{{ $aset->kode_barang }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">NUP</h4>
                            <p class="text-base text-gray-900">{{ $aset->nup ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Jenis BMN</h4>
                            <p class="text-base text-gray-900">{{ $aset->jenis_bmn }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Lokasi Ruangan</h4>
                            <p class="text-base text-gray-900">{{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tahun Perolehan</h4>
                            <p class="text-base text-gray-900">{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('Y') : '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Nilai Perolehan Pertama</h4>
                            <p class="text-base text-gray-900">Rp {{ number_format($aset->nilai_perolehan_pertama, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
