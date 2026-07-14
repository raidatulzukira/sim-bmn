<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kasubag TU') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang, Kasubag TU ") . Auth::user()->name . "!" }}
                </div>
            </div>

            <!-- Pengajuan Pending Keseluruhan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pengajuan Menunggu Persetujuan</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 mb-4">{{ $jumlahPending ?? 0 }}</div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-md flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">Peminjaman Aset</span>
                            <span class="block text-2xl font-bold text-gray-800">{{ $jumlahPeminjamanPending ?? 0 }}</span>
                        </div>
                        <a href="{{ route('kasubag.persetujuan.index', ['tab' => 'pending']) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">Tinjau Peminjaman &rarr;</a>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">Pemeliharaan Aset</span>
                            <span class="block text-2xl font-bold text-gray-800">{{ $jumlahPemeliharaanPending ?? 0 }}</span>
                        </div>
                        <a href="{{ route('kasubag.persetujuan_pemeliharaan.index', ['tab' => 'pending']) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">Tinjau Pemeliharaan &rarr;</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
