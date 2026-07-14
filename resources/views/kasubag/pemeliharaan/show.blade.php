<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Review Persetujuan Pemeliharaan') }}
            </h2>
            <a href="{{ route('kasubag.persetujuan_pemeliharaan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showRejectModal: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-md {{ $pemeliharaan->jenis === 'rutin' ? 'bg-gray-100 text-gray-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ ucfirst($pemeliharaan->jenis) }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $pemeliharaan->asetBmn->nama_aset }}</h3>
                            <p class="text-gray-500 mt-1">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $pemeliharaan->asetBmn->kode_aset }}</span></p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500 mb-1">Status</span>
                            @php
                                $color = match($pemeliharaan->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-blue-100 text-blue-800',
                                    'proses' => 'bg-orange-100 text-orange-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($pemeliharaan->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Pengajuan</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Pengajuan</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $pemeliharaan->tanggal_pengajuan->format('d F Y, H:i') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Pelapor / Pengaju</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $pemeliharaan->jenis === 'situasional' ? $pemeliharaan->pelapor->name : 'Operator (Sistem Rutin)' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if($pemeliharaan->status !== 'pending')
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Keputusan TU</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Diputuskan Oleh</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $pemeliharaan->approver->name ?? '-' }}</span>
                                </div>
                                @if($pemeliharaan->status === 'ditolak')
                                    <div>
                                        <span class="block text-xs text-red-500 font-bold">Alasan Penolakan</span>
                                        <span class="block text-sm font-medium text-red-700">{{ $pemeliharaan->catatan_validasi }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan / Deskripsi Kerusakan</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap">{{ $pemeliharaan->deskripsi_kerusakan ?? 'Tidak ada catatan yang diberikan.' }}</div>
                    </div>

                    <!-- AKSI KASUBAG TU -->
                    @if($pemeliharaan->status === 'pending')
                        <div class="border-t border-gray-200 pt-6 mt-6 flex justify-end space-x-3">
                            <!-- Tombol Tolak membuka Modal -->
                            <button type="button" @click="showRejectModal = true" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tolak Pengajuan
                            </button>

                            <!-- Form Setuju -->
                            <form action="{{ route('kasubag.persetujuan_pemeliharaan.approve', $pemeliharaan->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Setujui pengajuan pemeliharaan aset ini?');" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Setujui Pemeliharaan
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- REJECT MODAL -->
        @if($pemeliharaan->status === 'pending')
            <div x-show="showRejectModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="showRejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showRejectModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div x-show="showRejectModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('kasubag.persetujuan_pemeliharaan.reject', $pemeliharaan->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Pengajuan Pemeliharaan</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 mb-3">Anda wajib memberikan alasan penolakan agar diketahui oleh pengaju/pelapor.</p>
                                            <textarea name="catatan_validasi" rows="3" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" placeholder="Tulis alasan penolakan di sini..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Konfirmasi Tolak
                                </button>
                                <button type="button" @click="showRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
