<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cetak Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route(auth()->user()->role === 'operator' ? 'operator.laporan.generate' : 'kasubag.laporan.generate') }}" target="_blank">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="jenis_laporan" :value="__('Pilih Jenis Laporan')" />
                            <select id="jenis_laporan" name="jenis_laporan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required onchange="toggleFilters()">
                                <option value="" disabled selected>-- Pilih Laporan --</option>
                                <option value="rekap_pemeliharaan">Laporan Rekapitulasi Pemeliharaan</option>
                                <option value="riwayat_pemeliharaan_aset">Laporan Riwayat Pemeliharaan per Aset</option>
                                <option value="detail_pemeliharaan_aset">Laporan Detail Pemeliharaan per Aset</option>
                                <option value="riwayat_peminjaman_aset">Laporan Riwayat Peminjaman per Aset</option>
                                <option value="dbr">Laporan Daftar Barang Ruangan (DBR)</option>
                            </select>
                        </div>

                        <!-- Filter Rentang Tanggal -->
                        <div id="filter_tanggal" class="mb-6 hidden">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Filter Rentang Tanggal Pengajuan</h4>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <x-input-label for="tanggal_awal" :value="__('Tanggal Awal')" />
                                    <x-text-input id="tanggal_awal" class="block mt-1 w-full" type="date" name="tanggal_awal" />
                                </div>
                                <div class="flex-1">
                                    <x-input-label for="tanggal_akhir" :value="__('Tanggal Akhir')" />
                                    <x-text-input id="tanggal_akhir" class="block mt-1 w-full" type="date" name="tanggal_akhir" />
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menampilkan semua data tanpa batasan waktu.</p>
                        </div>

                        <!-- Filter Pilih Aset -->
                        <div id="filter_aset" class="mb-6 hidden">
                            <x-input-label for="aset_id" :value="__('Pilih Aset BMN')" />
                            <select id="aset_id" name="aset_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="" disabled selected>-- Pilih Aset --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}">[{{ $aset->kode_barang }}] {{ $aset->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Pilih Ruangan -->
                        <div id="filter_ruangan" class="mb-6 hidden">
                            <x-input-label for="ruangan_id" :value="__('Pilih Ruangan')" />
                            <select id="ruangan_id" name="ruangan_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="" disabled selected>-- Pilih Ruangan --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-4">
                            <button type="submit" name="format" value="excel" class="mr-4 px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700">
                                Export Excel
                            </button>
                            <button type="submit" name="format" value="pdf" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-semibold hover:bg-red-700">
                                Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFilters() {
            const jenis = document.getElementById('jenis_laporan').value;
            const filterTanggal = document.getElementById('filter_tanggal');
            const filterAset = document.getElementById('filter_aset');
            const filterRuangan = document.getElementById('filter_ruangan');
            const asetInput = document.getElementById('aset_id');
            const ruanganInput = document.getElementById('ruangan_id');

            // Reset visibilitas
            filterTanggal.classList.add('hidden');
            filterAset.classList.add('hidden');
            filterRuangan.classList.add('hidden');

            // Hapus required attribute terlebih dahulu
            asetInput.removeAttribute('required');
            ruanganInput.removeAttribute('required');

            if (jenis === 'rekap_pemeliharaan') {
                filterTanggal.classList.remove('hidden');
            } else if (jenis === 'riwayat_pemeliharaan_aset' || jenis === 'detail_pemeliharaan_aset' || jenis === 'riwayat_peminjaman_aset') {
                filterAset.classList.remove('hidden');
                asetInput.setAttribute('required', 'required');
            } else if (jenis === 'dbr') {
                filterRuangan.classList.remove('hidden');
                ruanganInput.setAttribute('required', 'required');
            }
        }
    </script>
</x-app-layout>
