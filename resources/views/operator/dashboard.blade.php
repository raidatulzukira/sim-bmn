<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Operator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Aset -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Aset BMN</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAset }}</div>
                </div>

                <!-- Aset Dipinjam -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Aset Dipinjam</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $asetDipinjam }}</div>
                </div>

                <!-- Aset Servis -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Aset Dalam Servis</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $asetServis }}</div>
                </div>
            </div>

            <!-- Alerts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Peminjaman Jatuh Tempo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-red-600 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Peringatan: Peminjaman Mendekati Jatuh Tempo
                        </h3>
                        
                        @if($alertPeminjaman->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($alertPeminjaman as $pinjam)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $pinjam->user->name }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $pinjam->asetBmn->nama_aset }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-red-600 font-semibold">
                                                    {{ $pinjam->tanggal_kembali_rencana->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada peminjaman yang mendekati jatuh tempo (H-2).</p>
                        @endif
                    </div>
                </div>

                <!-- Pemeliharaan Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-yellow-600 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Peringatan: Pemeliharaan Perlu Tindakan
                        </h3>
                        
                        @if($alertPemeliharaan->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($alertPemeliharaan as $rawat)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $rawat->asetBmn->nama_aset }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $rawat->jenis }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $rawat->status == 'pending' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($rawat->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada jadwal pemeliharaan yang berstatus pending atau proses.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
