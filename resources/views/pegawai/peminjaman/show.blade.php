<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Peminjaman') }}
            </h2>
            <a href="{{ route('pegawai.peminjaman.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
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
                            <h3 class="text-2xl font-bold text-gray-900">{{ $peminjaman->asetBmn->nama_aset }}</h3>
                            <p class="text-gray-500 mt-1">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $peminjaman->asetBmn->kode_aset }}</span></p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500 mb-1">Status Peminjaman</span>
                            @php
                                $color = match($peminjaman->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-blue-100 text-blue-800',
                                    'dipinjam' => 'bg-green-100 text-green-800',
                                    'dikembalikan' => 'bg-gray-100 text-gray-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </div>
                    </div>

                    @if($peminjaman->status === 'ditolak')
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <h4 class="text-sm font-bold text-red-800 mb-1">Alasan Penolakan:</h4>
                            <p class="text-sm text-red-700">{{ $peminjaman->catatan_penolakan }}</p>
                            @if($peminjaman->approver)
                                <p class="text-xs text-red-500 mt-2">Ditolak oleh: {{ $peminjaman->approver->name }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Waktu</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Pengajuan</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->created_at->format('d F Y, H:i') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Rencana Pinjam (Estimasi)</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->estimasi_waktu_pinjam->format('d F Y') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Rencana Kembali</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Realisasi (Oleh Operator)</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Aktual Serah Terima</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->tanggal_pinjam ? $peminjaman->tanggal_pinjam->format('d F Y, H:i') : '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Aktual Dikembalikan</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->tanggal_kembali_aktual ? $peminjaman->tanggal_kembali_aktual->format('d F Y, H:i') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Keperluan Peminjaman</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap">{{ $peminjaman->keperluan }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
