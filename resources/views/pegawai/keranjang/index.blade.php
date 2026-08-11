@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center text-sky-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Keranjang Peminjaman') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start gap-4">
                    <svg class="w-6 h-6 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold text-emerald-800">Berhasil</h3>
                        <p class="text-sm text-emerald-600 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-start gap-4">
                    <svg class="w-6 h-6 text-rose-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold text-rose-800">Gagal</h3>
                        <p class="text-sm text-rose-600 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('pegawai.peminjaman.create') }}" method="GET" id="checkout-form">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6 pb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Daftar Aset Dipilih</h3>
                                <p class="text-sm text-slate-500">Pilih aset yang ingin diajukan peminjamannya sekarang</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="select-all" class="rounded border-slate-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50 w-5 h-5 cursor-pointer">
                                <label for="select-all" class="text-sm font-bold text-slate-700 cursor-pointer">Pilih Semua</label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($keranjang as $item)
                                <div class="flex items-start sm:items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-colors bg-white">
                                    <input type="checkbox" name="keranjang_ids[]" value="{{ $item->id }}" class="item-checkbox mt-1 sm:mt-0 rounded border-slate-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50 w-5 h-5 cursor-pointer">
                                    
                                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-base font-bold text-slate-900 truncate">
                                            {{ $item->asetBmn->nama_barang }}
                                        </h4>
                                        <p class="text-sm text-slate-500 truncate mt-0.5">
                                            {{ $item->asetBmn->merk ?? '-' }} {{ $item->asetBmn->tipe ? '- ' . $item->asetBmn->tipe : '' }}
                                        </p>
                                        @if($item->jumlah > $item->stok_tersedia)
                                            <p class="text-xs text-rose-600 font-bold mt-1">Stok tidak mencukupi (Tersedia: {{ $item->stok_tersedia }})</p>
                                        @else
                                            <p class="text-xs text-emerald-600 font-bold mt-1">Stok Tersedia: {{ $item->stok_tersedia }}</p>
                                        @endif
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-end sm:items-center gap-4 shrink-0">
                                        <div class="text-right">
                                            <span class="text-xs text-slate-500 font-medium block">Jumlah</span>
                                            <span class="text-base font-bold text-slate-800">{{ $item->jumlah }}</span>
                                        </div>

                                        <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus dari Keranjang">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 px-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-1">Keranjang Kosong</h3>
                                    <p class="text-slate-500 mb-6">Anda belum menambahkan aset apapun ke keranjang.</p>
                                    <a href="{{ route('pegawai.katalog_aset.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 transition-colors">
                                        Lihat Katalog Aset
                                    </a>
                                </div>
                            @endforelse
                        </div>

                        @if($keranjang->count() > 0)
                            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <a href="{{ route('pegawai.katalog_aset.index') }}" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors text-center">
                                    Kembali ke Katalog
                                </a>
                                <button type="submit" id="btn-checkout" disabled class="w-full sm:w-auto px-8 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-bold hover:bg-sky-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm flex items-center justify-center gap-2">
                                    Lanjut Pengajuan (<span id="selected-count">0</span>)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Formulir hapus tersembunyi -->
            @foreach($keranjang as $item)
                <form id="delete-form-{{ $item->id }}" action="{{ route('pegawai.keranjang.destroy', $item->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const btnCheckout = document.getElementById('btn-checkout');
            const selectedCount = document.getElementById('selected-count');

            function updateCheckoutButton() {
                const checked = document.querySelectorAll('.item-checkbox:checked').length;
                if (selectedCount) {
                    selectedCount.textContent = checked;
                }
                if (btnCheckout) {
                    btnCheckout.disabled = checked === 0;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateCheckoutButton();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked && selectAll) {
                        selectAll.checked = false;
                    } else if (document.querySelectorAll('.item-checkbox:checked').length === checkboxes.length && selectAll) {
                        selectAll.checked = true;
                    }
                    updateCheckoutButton();
                });
            });
            
            updateCheckoutButton();
        });
    </script>
    @endpush
@endsection
