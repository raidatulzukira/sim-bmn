<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Aset BMN') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('operator.aset.edit', $aset->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                    Edit Aset
                </a>
                <a href="{{ route('operator.aset.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1 border-r border-gray-200 pr-4">
                        @if($aset->foto)
                            <img src="{{ asset('storage/' . $aset->foto) }}" alt="{{ $aset->nama_barang }}" class="w-full h-auto rounded-lg shadow-sm">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="mb-4">
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Status Aset</span>
                            <div class="mt-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $aset->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($aset->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($aset->status) }}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $aset->nama_barang }}</h3>
                        <p class="text-gray-600 text-sm mb-6">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $aset->kode_barang }}</span></p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Jenis BMN</span>
                                <span class="block text-gray-900">{{ $aset->jenis_bmn }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">NUP</span>
                                <span class="block text-gray-900">{{ $aset->nup ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Merk / Tipe</span>
                                <span class="block text-gray-900">{{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Nama (Opsional)</span>
                                <span class="block text-gray-900">{{ $aset->nama ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Tanggal Perolehan</span>
                                <span class="block text-gray-900">{{ \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Nilai Perolehan Pertama</span>
                                <span class="block text-gray-900">Rp {{ number_format($aset->nilai_perolehan_pertama, 2, ',', '.') }}</span>
                            </div>
                            <div class="sm:col-span-2 md:col-span-3">
                                <span class="block text-sm font-medium text-gray-500">Lokasi Ruangan</span>
                                <span class="block text-gray-900">{{ $aset->ruangan ? $aset->ruangan->nama_ruangan : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Riwayat Peminjaman -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Riwayat Peminjaman Terakhir</h4>
                    @if($aset->peminjaman->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($aset->peminjaman as $pinjam)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $pinjam->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $pinjam->keperluan }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                                {{ $pinjam->status }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">{{ $pinjam->tanggal_pinjam?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 italic">Belum ada riwayat peminjaman.</p>
                    @endif
                </div>

                <!-- Riwayat Pemeliharaan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Riwayat Pemeliharaan Terakhir</h4>
                    @if($aset->pemeliharaan->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($aset->pemeliharaan as $rawat)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 capitalize">{{ $rawat->jenis }}</p>
                                            <p class="text-xs text-gray-500">Oleh: {{ $rawat->pelapor->name ?? '-' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                                {{ $rawat->status }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">{{ $rawat->tanggal_pengajuan?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 italic">Belum ada riwayat pemeliharaan.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
