<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex justify-between items-center border-b pb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Peminjaman</h3>
                        @php
                            $color = match($peminjaman->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'disetujui' => 'bg-blue-100 text-blue-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                'dipinjam' => 'bg-indigo-100 text-indigo-800',
                                'dikembalikan' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize {{ $color }}">
                            Status: {{ $peminjaman->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Aset BMN yang Dipinjam</h4>
                            <p class="text-base text-gray-900 font-semibold">{{ $peminjaman->asetBmn->nama_barang }}</p>
                            <p class="text-sm text-gray-600">Kode: {{ $peminjaman->asetBmn->kode_barang }}</p>
                            <p class="text-sm text-gray-600">Merk/Tipe: {{ $peminjaman->asetBmn->merk ?? '-' }} / {{ $peminjaman->asetBmn->tipe ?? '-' }}</p>
                            @if($peminjaman->asetBmn->ruangan)
                                <p class="text-sm text-gray-600 mt-1">Lokasi Asal: {{ $peminjaman->asetBmn->ruangan->nama_ruangan }}</p>
                            @endif
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Jadwal Peminjaman</h4>
                            <p class="text-sm text-gray-900"><strong>Tgl Pengajuan:</strong> {{ $peminjaman->created_at->format('d M Y H:i') }}</p>
                            <p class="text-sm text-gray-900 mt-1"><strong>Estimasi Pinjam:</strong> {{ $peminjaman->estimasi_waktu_pinjam->format('d M Y') }}</p>
                            <p class="text-sm text-gray-900 mt-1"><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                            @if($peminjaman->tanggal_kembali_aktual)
                                <p class="text-sm text-gray-900 mt-1"><strong>Aktual Kembali:</strong> <span class="text-green-600">{{ $peminjaman->tanggal_kembali_aktual->format('d M Y H:i') }}</span></p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Keperluan Peminjaman</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $peminjaman->keperluan }}</p>
                        </div>
                    </div>

                    @if($peminjaman->status === 'ditolak' && $peminjaman->catatan_penolakan)
                        <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <h4 class="text-sm font-semibold text-red-800 mb-1">Catatan Penolakan (Oleh Kasubag TU)</h4>
                            <p class="text-sm text-red-700">{{ $peminjaman->catatan_penolakan }}</p>
                        </div>
                    @endif

                    @if(in_array($peminjaman->status, ['disetujui', 'dipinjam', 'dikembalikan']) && $peminjaman->approver)
                        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                            <p class="text-sm text-blue-700">Telah disetujui oleh <strong>{{ $peminjaman->approver->name }}</strong></p>
                        </div>
                    @endif

                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-start">
                        <a href="{{ route('pegawai.peminjaman.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                            Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
