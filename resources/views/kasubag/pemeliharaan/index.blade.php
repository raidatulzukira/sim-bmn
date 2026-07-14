<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Pemeliharaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'pending']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Menunggu Persetujuan
                        </a>
                        <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'riwayat']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'riwayat' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Riwayat Diproses
                        </a>
                    </nav>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pengajuan</th>
                                @if($tab === 'riwayat')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pemeliharaans as $rawat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rawat->asetBmn->nama_aset }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-md {{ $rawat->jenis === 'rutin' ? 'bg-gray-100 text-gray-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ ucfirst($rawat->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rawat->jenis === 'situasional' ? $rawat->pelapor->name : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rawat->tanggal_pengajuan->format('d M Y') }}</td>
                                    
                                    @if($tab === 'riwayat')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $color = match($rawat->status) {
                                                    'disetujui' => 'bg-blue-100 text-blue-800',
                                                    'proses' => 'bg-orange-100 text-orange-800',
                                                    'selesai' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst($rawat->status) }}
                                            </span>
                                        </td>
                                    @endif
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('kasubag.persetujuan_pemeliharaan.show', $rawat->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $tab === 'pending' ? 'Review Pengajuan' : 'Detail' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $tab === 'riwayat' ? 6 : 5 }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada data {{ $tab === 'pending' ? 'yang menunggu persetujuan.' : 'riwayat pemeliharaan.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200">
                    {{ $pemeliharaans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
