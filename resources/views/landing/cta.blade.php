<section class="py-24 relative overflow-hidden bg-slate-50">
    <div class="hero-mesh absolute inset-0"></div>
    <div class="absolute inset-0 dot-grid opacity-30" style="background-image: radial-gradient(circle, rgba(15,23,42,0.06) 1px, transparent 1px);"></div>
    <div class="mesh-blob absolute w-[400px] h-[400px] top-0 left-0 bg-sky-300/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="mesh-blob-2 absolute w-[300px] h-[300px] bottom-0 right-0 bg-blue-300/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10 reveal">
        <!-- <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase text-amber-600 bg-amber-50 border border-amber-200 mb-8 shadow-sm">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Platform Resmi Kemenperin
        </div> -->
        <h2 class="text-4xl md:text-6xl font-black text-slate-900 mb-8 leading-tight">
            Siap Mengelola Aset<br><span class="grad-blue">Secara Digital?</span>
        </h2>
        <p class="text-slate-600 text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
            Masuk ke sistem dan mulai kelola seluruh Barang Milik Negara dengan lebih efisien, terstruktur, dan transparan.
        </p>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-3 btn-glow px-10 py-5 text-white font-bold rounded-2xl text-lg shadow-xl shadow-sky-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Buka Dashboard Saya
                </a>
            @else
                <button onclick="openLoginModal()" class="inline-flex items-center gap-3 btn-glow px-10 py-5 text-white font-bold rounded-2xl text-lg shadow-xl shadow-sky-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk ke Sistem Sekarang
                </button>
            @endauth
        @endif
    </div>
</section>
