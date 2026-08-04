@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('operator.pemeliharaan.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-600 hover:border-sky-200 hover:bg-sky-50 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Ajukan Jadwal Servis Rutin') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-slate-100">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-slate-100 pb-6 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shadow-sm border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Form Servis Rutin Aset</h3>
                            <p class="text-sm text-slate-500 mt-1">Isi detail aset yang akan diservis secara rutin.</p>
                        </div>
                    </div>
                
                    @if($asets->count() == 0)
                        <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-2xl flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-yellow-800 font-bold mb-1">Aset Tidak Tersedia</h4>
                                <p class="text-sm text-yellow-700 leading-relaxed">Saat ini tidak ada aset BMN berstatus tersedia yang bisa diajukan servisnya. (Aset yang sedang dipinjam atau dalam proses pemeliharaan tidak akan muncul di sini).</p>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('operator.pemeliharaan.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <!-- Bagian Pilih Aset -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset <span class="text-red-500">*</span></label>
                                @if(isset($kodeBarang))
                                    <div class="mb-3 px-4 py-2 bg-sky-50 border border-sky-100 rounded-lg text-sm text-sky-800 font-medium">
                                        Menampilkan aset dengan kode: <strong>{{ $kodeBarang }}</strong>
                                    </div>
                                @endif
                                <div class="bg-white border border-slate-200 rounded-xl max-h-64 overflow-y-auto divide-y divide-slate-100 shadow-inner">
                                    <div class="p-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between sticky top-0 z-10">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="selectAll" class="rounded border-slate-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50 h-4 w-4">
                                            <span class="ml-2 text-sm font-bold text-slate-700">Pilih Semua ({{ $asets->count() }} Aset)</span>
                                        </label>
                                    </div>
                                    <div class="p-2 space-y-1">
                                        @foreach($asets as $aset)
                                            <label class="flex items-start p-3 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors border border-transparent hover:border-slate-100">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="aset_ids[]" value="{{ $aset->id }}" class="aset-checkbox rounded border-slate-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50 h-4 w-4"
                                                    {{ (is_array(old('aset_ids')) && in_array($aset->id, old('aset_ids'))) || (!old('aset_ids') && isset($kodeBarang)) ? 'checked' : '' }}>
                                                </div>
                                                <div class="ml-3 flex flex-col">
                                                    <span class="text-sm font-bold text-slate-700 leading-tight">{{ $aset->nama_barang }}</span>
                                                    <span class="text-xs text-slate-500 font-mono mt-0.5">NUP: {{ $aset->nup }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                @error('aset_ids')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                @error('aset_ids.*')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="text-xs font-medium text-slate-500 mt-2 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    Pilih satu atau lebih aset untuk diservis sekaligus. Aset yang dipilih akan digabungkan dalam satu pengajuan (batch) untuk memudahkan proses.
                                </p>
                            </div>

                            <script>
                                document.getElementById('selectAll').addEventListener('change', function() {
                                    const checkboxes = document.querySelectorAll('.aset-checkbox');
                                    checkboxes.forEach(cb => cb.checked = this.checked);
                                });
                                
                                const checkboxes = document.querySelectorAll('.aset-checkbox');
                                checkboxes.forEach(cb => {
                                    cb.addEventListener('change', function() {
                                        const allChecked = Array.from(checkboxes).every(c => c.checked);
                                        const someChecked = Array.from(checkboxes).some(c => c.checked);
                                        const selectAll = document.getElementById('selectAll');
                                        selectAll.checked = allChecked;
                                        selectAll.indeterminate = someChecked && !allChecked;
                                    });
                                });
                                
                                // Trigger initial state
                                if (checkboxes.length > 0) {
                                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                                    const someChecked = Array.from(checkboxes).some(c => c.checked);
                                    const selectAll = document.getElementById('selectAll');
                                    selectAll.checked = allChecked;
                                    selectAll.indeterminate = someChecked && !allChecked;
                                }
                            </script>

                            <div>
                                <label for="deskripsi_kerusakan" class="block text-sm font-bold text-slate-700 mb-2">Catatan / Area Servis <span class="text-slate-400 font-normal ml-1">(Opsional)</span></label>
                                <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" class="block w-full border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 sm:text-sm transition-colors duration-200 bg-slate-50/50 focus:bg-white px-4 py-3" placeholder="Misal: Ganti oli rutin, pembersihan kipas, pengecekan fungsi utama, dll...">{{ old('deskripsi_kerusakan') }}</textarea>
                                @error('deskripsi_kerusakan')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                                <a href="{{ route('operator.pemeliharaan.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 bg-sky-700 text-white rounded-xl text-sm font-bold hover:bg-sky-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Ajukan Servis Rutin
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
