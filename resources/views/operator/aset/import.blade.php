<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Data Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{!! session('error') !!}</span>
                    </div>
                @endif

                <div class="mb-6 bg-blue-50 text-blue-800 p-4 rounded-md text-sm">
                    <strong>Panduan Import:</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Gunakan file Excel (<code>.xlsx</code>, <code>.xls</code>) atau <code>.csv</code>.</li>
                        <li>Pastikan baris pertama (header) berisi: <code>Jenis BMN</code>, <code>Kode Barang</code>, <code>NUP</code>, <code>Nama Barang</code>, <code>Merk</code>, <code>Tipe</code>, <code>Nama</code>, <code>Tanggal Perolehan</code>, <code>Nilai Perolehan Pertama</code>.</li>
                        <li>Format Tanggal Perolehan harus disesuaikan agar terbaca oleh sistem (bisa menggunakan format teks YYYY-MM-DD atau format Date Excel).</li>
                        <li>Nilai Perolehan Pertama harus berupa angka, hilangkan titik atau koma jika diperlukan.</li>
                        <li>Maksimal ukuran file: 5MB.</li>
                    </ul>
                </div>

                <form action="{{ route('operator.aset.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="file_excel" value="Pilih File Excel/CSV *" />
                        <input type="file" id="file_excel" name="file_excel" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".xlsx, .xls, .csv" required />
                        <x-input-error :messages="$errors->get('file_excel')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('operator.aset.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                            Batal
                        </a>
                        <x-primary-button>
                            Import Data
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
