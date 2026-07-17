<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Peminjaman & Serah Terima') }}
            </h2>
            <a href="{{ route('operator.peminjaman.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
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
                            <h3 class="text-2xl font-bold text-gray-900">{{ $peminjaman->asetBmn->nama_barang }}</h3>
                            <p class="text-gray-500 mt-1">Kode Aset: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $peminjaman->asetBmn->kode_barang }}</span></p>
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

                    @if($peminjaman->foto_serah_terima || $peminjaman->foto_pengembalian)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            @if($peminjaman->foto_serah_terima)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Bukti Serah Terima</h4>
                                    <img src="{{ asset('storage/' . $peminjaman->foto_serah_terima) }}" class="mt-2 w-full max-w-md rounded-lg shadow-sm border border-gray-200" alt="Bukti Serah Terima">
                                    
                                    <div class="mt-3 text-sm text-gray-600">
                                        <strong>Diserahkan pada:</strong> {{ $peminjaman->tanggal_pinjam->format('d F Y H:i') }}
                                    </div>
                                </div>
                            @endif

                            @if($peminjaman->foto_pengembalian)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Bukti Pengembalian</h4>
                                    <img src="{{ asset('storage/' . $peminjaman->foto_pengembalian) }}" class="mt-2 w-full max-w-md rounded-lg shadow-sm border border-gray-200" alt="Bukti Pengembalian">
                                    
                                    <div class="mt-3 text-sm text-gray-600">
                                        <strong>Dikembalikan pada:</strong> {{ $peminjaman->tanggal_kembali_aktual->format('d F Y H:i') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($peminjaman->status === 'disetujui')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Proses Serah Terima Aset</h4>
                            
                            <form action="{{ route('operator.peminjaman.serah_terima', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="foto_serah_terima" value="Unggah Bukti Foto Serah Terima (Wajib) *" />
                                    <input type="file" id="foto_serah_terima" name="foto_serah_terima" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*" required />
                                    <x-input-error :messages="$errors->get('foto_serah_terima')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-1">Pastikan foto terlihat jelas, menampilkan fisik barang saat diserahkan.</p>
                                </div>

                                <x-primary-button onclick="return confirm('Apakah Anda yakin barang ini telah diserahkan kepada {{ $peminjaman->user->name }}?');">
                                    Konfirmasi Serah Terima Barang
                                </x-primary-button>
                            </form>
                        </div>
                    @elseif($peminjaman->status === 'dipinjam')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                                <h4 class="text-lg font-semibold text-gray-800">Proses Pengembalian Aset</h4>
                                
                                <!-- Kirim Reminder -->
                                <form action="{{ route('operator.peminjaman.reminder', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Kirim notifikasi pengingat ke Pegawai via WhatsApp?');" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        Kirim Notifikasi Pengingat
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('operator.peminjaman.dikembalikan', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="foto_pengembalian" value="Unggah Bukti Foto Barang Dikembalikan (Wajib) *" />
                                    <input type="file" id="foto_pengembalian" name="foto_pengembalian" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*" required />
                                    <x-input-error :messages="$errors->get('foto_pengembalian')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-1">Pastikan foto terlihat jelas, menampilkan fisik barang yang telah dikembalikan ke ruangan Operator.</p>
                                </div>

                                <button type="submit" onclick="return confirm('Apakah Anda yakin barang ini telah diterima kembali secara fisik beserta fotonya?');" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Konfirmasi Barang Dikembalikan
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
