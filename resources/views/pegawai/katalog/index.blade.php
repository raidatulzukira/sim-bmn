<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Aset BMN') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter & Search -->
            <div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6">
                <form method="GET" action="{{ route('pegawai.katalog_aset.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-text-input name="search" value="{{ request('search') }}" class="w-full" placeholder="Cari kode atau nama aset..." />
                    </div>
                    <div>
                        <x-text-input name="jenis_bmn" value="{{ request('jenis_bmn') }}" class="w-full sm:w-auto" placeholder="Jenis BMN..." />
                    </div>
                    <div>
                        <x-primary-button type="submit">Cari</x-primary-button>
                        <a href="{{ route('pegawai.katalog_aset.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Grid Aset -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($asets as $aset)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 flex flex-col">
                        <div class="h-48 bg-gray-200 relative">
                            @if($aset->foto)
                                <img src="{{ asset('storage/' . $aset->foto) }}" alt="{{ $aset->nama_barang }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $aset->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($aset->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($aset->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg text-gray-900 mb-1 truncate" title="{{ $aset->nama_barang }}">{{ $aset->nama_barang }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $aset->merk ?? 'Tanpa Merk' }}</p>
                            
                            <div class="mt-auto space-y-1 text-sm text-gray-600">
                                <p><span class="font-medium">Kode:</span> {{ $aset->kode_barang }}</p>
                                <p><span class="font-medium">Lokasi:</span> {{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}</p>
                            </div>
                            
                            <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                                <a href="{{ route('pegawai.katalog_aset.show', $aset->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold inline-flex items-center">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                        Tidak ada data katalog aset BMN yang ditemukan.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $asets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
