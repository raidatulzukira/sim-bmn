<nav class="navbar-glass sticky top-0 z-50 transition-all duration-500" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[72px] items-center">
            <!-- Brand -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 border-r border-slate-200 pr-4">
                    <!-- Note: For light theme, removed invert filter if the original logo is colored. If the original logo is white, we must use invert to make it dark. Assuming colored original based on 'EPS [Converted]'. -->
                    <img src="{{ asset('storage/images/LOGO KEMENTERIAN EPS [Converted].png') }}" alt="Kemenperin" class="h-9 object-contain">
                    <div class="h-6 w-px bg-slate-300"></div>
                    <img src="{{ asset('storage/images/Logo BDI Padang horizontal (NEW).png') }}" alt="BDI Padang" class="h-8 object-contain">
                </div>
                <div class="hidden sm:flex flex-col">
                    <span class="font-black text-lg text-slate-900 tracking-tight leading-none">SIM <span class="grad-blue">BMN</span></span>
                    <span class="text-[10px] text-slate-500 tracking-widest uppercase font-bold">Balai Diklat Industri</span>
                </div>
            </div>
            <!-- Nav Links -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="#" class="px-4 py-2 text-sm text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg font-bold transition-all duration-200">Beranda</a>
                <a href="#fitur" class="px-4 py-2 text-sm text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg font-bold transition-all duration-200">Fitur Sistem</a>
                <a href="#statistik" class="px-4 py-2 text-sm text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg font-bold transition-all duration-200">Statistik</a>
                <a href="#alur" class="px-4 py-2 text-sm text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg font-bold transition-all duration-200">Alur Sistem</a>
            </div>
            <!-- CTA -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-glow px-6 py-2.5 text-sm text-white font-bold rounded-full flex items-center gap-2 shadow-lg shadow-sky-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                    @else
                        <button onclick="openLoginModal()" class="btn-glow px-6 py-2.5 text-sm text-white font-bold rounded-full flex items-center gap-2 shadow-lg shadow-sky-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk Aplikasi
                        </button>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>
