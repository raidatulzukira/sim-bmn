<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Aset BMN') }}
            </h2>
            <a href="{{ route('operator.aset.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">
                Tambah Aset
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter & Search -->
            <div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6">
                <form method="GET" action="{{ route('operator.aset.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-text-input name="search" value="{{ request('search') }}" class="w-full" placeholder="Cari kode atau nama aset..." />
                    </div>
                    <div>
                        <select name="kategori" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-auto">
                            <option value="">Semua Kategori</option>
                            <option value="Elektronik" {{ request('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Furnitur" {{ request('kategori') == 'Furnitur' ? 'selected' : '' }}>Furnitur</option>
                            <option value="Kendaraan" {{ request('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                            <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-auto">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="servis" {{ request('status') == 'servis' ? 'selected' : '' }}>Servis</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Cari</x-primary-button>
                        <a href="{{ route('operator.aset.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Aset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Aset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($asets as $aset)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $aset->kode_aset }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aset->nama_aset }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aset->kategori }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aset->ruangan->nama_ruangan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $aset->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($aset->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($aset->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('operator.aset.show', $aset->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                        <a href="{{ route('operator.aset.edit', $aset->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('operator.aset.destroy', $aset->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data aset BMN.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200">
                    {{ $asets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
