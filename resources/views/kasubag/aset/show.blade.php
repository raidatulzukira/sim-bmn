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
                <!-- Detail Informasi -->
                <div class="w-full p-6">
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
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Perolehan</h4>
                            <p class="text-base text-gray-900">{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d M Y') : '-' }}</p>
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
