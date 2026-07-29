<section id="statistik" class="py-16 bg-white relative overflow-hidden">
    <div class="absolute inset-0 dot-grid opacity-50 pointer-events-none" style="background-image: radial-gradient(circle, rgba(15,23,42,0.06) 1px, transparent 1px);"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[200px] bg-sky-100/50 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 reveal">
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase text-sky-600 bg-sky-50 border border-sky-100 mb-4 shadow-sm">Data Terintegrasi</span>
            <h2 class="text-3xl md:text-4xl font-black text-slate-900">Angka Berbicara</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="bg-white rounded-3xl p-8 text-center reveal d-100 group border border-slate-100 shadow-lg shadow-slate-200/40 hover:border-sky-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-sky-100 transition-colors">
                    <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-4xl md:text-5xl font-black text-slate-800 mb-2 counter" data-target="{{ $totalAset }}">0</p>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wide">Total Aset BMN</p>
                <div class="mt-4 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-sky-400 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            <!-- Stat 2 -->
            <div class="bg-white rounded-3xl p-8 text-center reveal d-200 group border border-slate-100 shadow-lg shadow-slate-200/40 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <p class="text-4xl md:text-5xl font-black text-slate-800 mb-2 counter" data-target="{{ $totalRuangan }}">0</p>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wide">Ruangan / Lokasi</p>
                <div class="mt-4 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            <!-- Stat 3 -->
            <div class="bg-white rounded-3xl p-8 text-center reveal d-300 group border border-slate-100 shadow-lg shadow-slate-200/40 hover:border-amber-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-amber-100 transition-colors">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <p class="text-4xl md:text-5xl font-black text-slate-800 mb-2 counter" data-target="{{ $peminjamanAktif }}">0</p>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wide">Peminjaman Aktif</p>
                <div class="mt-4 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-amber-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            <!-- Stat 4 -->
            <div class="bg-white rounded-3xl p-8 text-center reveal d-400 group border border-slate-100 shadow-lg shadow-slate-200/40 hover:border-rose-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-rose-100 transition-colors">
                    <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-4xl md:text-5xl font-black text-slate-800 mb-2 counter" data-target="{{ $sedangDipelihara }}">0</p>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wide">Sedang Dipelihara</p>
                <div class="mt-4 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-rose-400 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
        </div>
    </div>
</section>
