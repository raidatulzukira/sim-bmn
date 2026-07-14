<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Eksekusi Pemeliharaan Aset') }}
            </h2>
            <a href="{{ route('operator.pemeliharaan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
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
                                <span class="px-2 py-1 text-xs font-semibold rounded-md {{ $pemeliharaan->jenis === 'rutin' ? 'bg-gray-100 text-gray-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ ucfirst($pemeliharaan->jenis) }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $pemeliharaan->asetBmn->nama_aset }}</h3>
                            <p class="text-gray-500 mt-1">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $pemeliharaan->asetBmn->kode_aset }}</span></p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500 mb-1">Status Servis</span>
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
                                @if($pemeliharaan->jenis === 'situasional')
                                <div>
                                    <span class="block text-xs text-gray-500">Dilaporkan Oleh</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $pemeliharaan->pelapor->name }}</span>
                                </div>
                                @endif
                                @if($pemeliharaan->tanggal_selesai)
                                <div>
                                    <span class="block text-xs text-gray-500">Tanggal Selesai</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $pemeliharaan->tanggal_selesai->format('d F Y, H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Persetujuan TU</h4>
                            @if($pemeliharaan->status === 'pending')
                                <p class="text-sm text-yellow-600">Menunggu persetujuan Kasubag TU.</p>
                            @else
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
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan / Deskripsi Kerusakan</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap">{{ $pemeliharaan->deskripsi_kerusakan ?? 'Tidak ada catatan.' }}</div>
                    </div>

                    <!-- AKSI OPERATOR -->
                    @if($pemeliharaan->status === 'disetujui')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Mulai Tindakan Pemeliharaan
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">Pengajuan telah disetujui. Tekan tombol di bawah untuk memulai proses perbaikan. <strong>Status aset BMN ini akan otomatis diubah menjadi "Servis" di sistem master data.</strong></p>
                            
                            <form action="{{ route('operator.pemeliharaan.proses', $pemeliharaan->id) }}" method="POST">
                                @csrf
                                <x-primary-button onclick="return confirm('Mulai proses servis aset ini?');" class="bg-indigo-600 hover:bg-indigo-700">
                                    Tandai Mulai Diproses (Servis)
                                </x-primary-button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'proses')
                        <div class="border-t border-gray-200 pt-6 mt-6 bg-orange-50 -mx-6 px-6 pb-6 rounded-b-lg">
                            <h4 class="text-lg font-semibold text-orange-800 mb-4">Selesaikan Pemeliharaan</h4>
                            <p class="text-sm text-orange-700 mb-4">Aset saat ini sedang berstatus <strong>Dalam Perbaikan</strong>. Jika teknisi telah selesai memperbaiki, silakan unggah Nota / Bukti Servis untuk menyelesaikan proses. <strong>Aset akan kembali berstatus "Tersedia".</strong></p>
                            
                            <form action="{{ route('operator.pemeliharaan.selesai', $pemeliharaan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="nota_teknisi" value="Nota Teknisi / Bukti Perbaikan (Wajib) *" />
                                    <input type="file" id="nota_teknisi" name="nota_teknisi" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-100 file:text-orange-800 hover:file:bg-orange-200" accept=".jpg,.jpeg,.png,.pdf" required />
                                    <x-input-error :messages="$errors->get('nota_teknisi')" class="mt-2" />
                                    <p class="text-xs text-orange-600 mt-1">Format yang diizinkan: JPG, PNG, PDF. Maksimal 5MB.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Anda yakin proses perbaikan aset ini telah selesai sepenuhnya?');" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Selesaikan Perbaikan
                                </button>
                            </form>
                        </div>
                    @elseif($pemeliharaan->status === 'selesai' && $pemeliharaan->nota_teknisi)
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Hasil Perbaikan (Nota Teknisi)</h4>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pemeliharaan->nota_teknisi) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File Nota
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
