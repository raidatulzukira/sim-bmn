<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Persetujuan Peminjaman') }}
            </h2>
            <a href="{{ route('kasubag.persetujuan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Pegawai</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Nama Peminjam</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->user->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">NIP</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->user->nip ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Kontak (WA)</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->user->no_wa ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Waktu</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Pengajuan</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->created_at->format('d F Y, H:i') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Rencana Pinjam - Kembali</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $peminjaman->estimasi_waktu_pinjam->format('d F Y') }} s/d {{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Keperluan Peminjaman</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap">{{ $peminjaman->keperluan }}</div>
                    </div>

                    @if($peminjaman->status === 'pending')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Aksi Persetujuan</h4>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Form Setujui -->
                                <form action="{{ route('kasubag.persetujuan.approve', $peminjaman->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Anda yakin menyetujui pengajuan ini?');">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                        Setujui Peminjaman
                                    </button>
                                </form>

                                <!-- Trigger Modal Tolak -->
                                <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')" class="flex-1 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                    Tolak Peminjaman
                                </button>
                            </div>

                            <!-- Modal Tolak -->
                            <div id="modal-tolak" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-tolak').classList.add('hidden')"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <form action="{{ route('kasubag.persetujuan.reject', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Peminjaman</h3>
                                                        <div class="mt-4">
                                                            <x-input-label for="catatan_penolakan" value="Alasan Penolakan (Wajib diisi) *" />
                                                            <textarea id="catatan_penolakan" name="catatan_penolakan" rows="3" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Konfirmasi Tolak
                                                </button>
                                                <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if($peminjaman->status === 'ditolak')
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-6">
                                <h4 class="text-sm font-bold text-red-800 mb-1">Catatan Penolakan Anda:</h4>
                                <p class="text-sm text-red-700">{{ $peminjaman->catatan_penolakan }}</p>
                            </div>
                        @else
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6">
                                <p class="text-sm text-blue-800">
                                    Pengajuan ini disetujui pada {{ $peminjaman->updated_at->format('d F Y H:i') }}.
                                </p>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
