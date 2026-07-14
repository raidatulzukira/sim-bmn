<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan Kerusakan') }}
            </h2>
            <a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-md bg-pink-100 text-pink-800">
                                    Situasional
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $laporan_kerusakan->asetBmn->nama_aset }}</h3>
                            <p class="text-gray-500 mt-1">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $laporan_kerusakan->asetBmn->kode_aset }}</span></p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500 mb-1">Status Laporan</span>
                            @php
                                $color = match($laporan_kerusakan->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-blue-100 text-blue-800',
                                    'proses' => 'bg-orange-100 text-orange-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($laporan_kerusakan->status) }}
                            </span>
                        </div>
                    </div>

                    @if($laporan_kerusakan->status === 'ditolak')
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <h4 class="text-sm font-bold text-red-800 mb-1">Alasan Penolakan:</h4>
                            <p class="text-sm text-red-700">{{ $laporan_kerusakan->catatan_validasi }}</p>
                            @if($laporan_kerusakan->approver)
                                <p class="text-xs text-red-500 mt-2">Ditolak oleh: {{ $laporan_kerusakan->approver->name }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Waktu Pengajuan</h4>
                        <p class="text-sm text-gray-900">{{ $laporan_kerusakan->tanggal_pengajuan->format('d F Y, H:i') }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Kerusakan</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap">{{ $laporan_kerusakan->deskripsi_kerusakan }}</div>
                    </div>

                    @if($laporan_kerusakan->status === 'selesai')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Hasil Perbaikan (Nota Teknisi)</h4>
                            <p class="text-sm text-gray-600 mb-4">Diselesaikan pada: <strong>{{ $laporan_kerusakan->tanggal_selesai->format('d F Y, H:i') }}</strong></p>
                            
                            @if($laporan_kerusakan->nota_teknisi)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $laporan_kerusakan->nota_teknisi) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Nota / Bukti Perbaikan
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
