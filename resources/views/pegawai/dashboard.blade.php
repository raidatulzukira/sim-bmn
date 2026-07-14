<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang, ") . Auth::user()->name . "!" }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Barang Sedang Dipinjam -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Barang Sedang Anda Pinjam</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $jumlahDipinjam ?? 0 }}</div>
                </div>

                <!-- Pengajuan Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Peminjaman Pending</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $jumlahPending ?? 0 }}</div>
                </div>

                <!-- Laporan Kerusakan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Laporan Kerusakan Diproses</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $jumlahLaporanDiproses ?? 0 }}</div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
