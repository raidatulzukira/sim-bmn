<section class="hero-mesh relative min-h-screen flex items-center overflow-hidden dot-grid">
    <!-- Mesh Blobs -->
    <div class="mesh-blob absolute w-[500px] h-[500px] -top-32 -left-32 bg-sky-400/20 rounded-full blur-3xl pointer-events-none z-0"></div>
    <div class="mesh-blob-2 absolute w-[400px] h-[400px] top-20 right-0 bg-blue-500/15 rounded-full blur-3xl pointer-events-none z-0"></div>
    <div class="mesh-blob-3 absolute w-[300px] h-[300px] bottom-0 left-1/3 bg-cyan-400/20 rounded-full blur-3xl pointer-events-none z-0"></div>
    
    <!-- Particles -->
    <div class="particle w-2 h-2 bg-sky-500/50 top-1/4 left-[10%]" style="animation-duration:4s;animation-delay:0s;"></div>
    <div class="particle w-1.5 h-1.5 bg-blue-500/50 top-1/3 left-[20%]" style="animation-duration:5s;animation-delay:1s;"></div>
    <div class="particle w-2.5 h-2.5 bg-cyan-500/40 top-1/2 left-[5%]" style="animation-duration:6s;animation-delay:2s;"></div>
    <div class="particle w-1.5 h-1.5 bg-sky-400/50 top-[70%] left-[15%]" style="animation-duration:4.5s;animation-delay:0.5s;"></div>
    <div class="particle w-2 h-2 bg-blue-400/50 top-[20%] right-[15%]" style="animation-duration:5.5s;animation-delay:1.5s;"></div>
    <div class="particle w-1 h-1 bg-slate-400/50 top-[40%] right-[8%]" style="animation-duration:3.5s;animation-delay:0.8s;"></div>
    <div class="particle w-2 h-2 bg-sky-500/40 top-[60%] right-[20%]" style="animation-duration:7s;animation-delay:2.5s;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Left Text -->
            <div class="text-center lg:text-left reveal-left">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-sky-100 border border-sky-200 text-sky-700 text-xs font-bold tracking-wider uppercase mb-8 badge-pulse">
                    <span class="relative flex h-2 w-2">
                        <span class="ping-ring absolute inline-flex h-full w-full rounded-full bg-sky-500"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-sky-500"></span>
                    </span>
                    Sistem Resmi Aktif &bull; Balai Diklat Industri Padang
                </div>
                <h1 class="text-8xl sm:text-5xl lg:text-[3.5rem] font-black text-slate-900 leading-[1.1] mb-6 tracking-tight">
                    Transformasi Digital<br>Pengelolaan<br>
                    <span class="grad-blue">Barang Milik Negara</span>
                </h1>
                <p class="text-slate-600 text-md leading-relaxed mb-10 max-w-xl mx-auto lg:mx-0">
                    Platform pengelolaan aset negara yang akurat dan terstruktur berbasis digital untuk kemudahan akses — mendukung tata kelola BMN yang transparan di lingkungan Balai Diklat Industri Padang.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="group btn-glow px-8 py-4 text-white font-bold rounded-2xl flex items-center justify-center gap-3 text-base shadow-lg shadow-sky-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Akses Dashboard
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <button onclick="openLoginModal()" class="group btn-glow px-8 py-4 text-white font-bold rounded-2xl flex items-center justify-center gap-3 text-base shadow-lg shadow-sky-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                Masuk ke Sistem
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        @endauth
                    @endif
                    <a href="#fitur" class="group px-8 py-4 text-slate-700 font-bold rounded-2xl flex items-center justify-center gap-3 text-base glass-card hover:bg-slate-100 transition-all duration-300">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        Lihat Modul
                    </a>
                </div>
                <!-- Trust Indicators -->
                <div class="mt-12 flex flex-wrap items-center gap-6 justify-center lg:justify-start">
                    <div class="flex items-center gap-2 text-slate-600 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Akses Multi-Peran
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-sky-100 border border-sky-200 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-sky-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Pencatatan Detail
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Laporan Otomatis
                    </div>
                </div>
            </div>

            <!-- Right: Dashboard Mockup -->
            <div class="hidden lg:block relative reveal-right d-200">
                <div class="float-card glass-card rounded-3xl p-1 shadow-2xl shadow-sky-900/10 border border-white/60">
                    <!-- Browser Header -->
                    <div class="bg-slate-100/80 rounded-t-[1.5rem] px-5 py-3 flex items-center gap-2 border-b border-slate-200/50">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        <div class="flex-1 mx-3">
                            <div class="bg-white/60 border border-slate-200 rounded-lg text-[11px] px-4 py-1.5 text-slate-500 font-mono flex items-center gap-2 max-w-[180px] mx-auto shadow-sm">
                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                sim-bmn.bdipadang.id
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard Content -->
                    <div class="bg-white/90 rounded-b-[1.5rem] p-6 backdrop-blur-md">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <p class="text-slate-800 font-black text-base">Dashboard</p>
                                <p class="text-slate-500 text-xs mt-0.5">Ringkasan Aset BMN</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-[10px] text-slate-500 font-bold">Live</span>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-bold text-xs ml-2 shadow-md shadow-sky-500/30">OP</div>
                            </div>
                        </div>
                        <!-- Stat Grid -->
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-sky-50 border border-sky-100 p-3 rounded-xl shadow-sm">
                                <p class="text-[10px] text-sky-600 font-bold mb-1">Total Aset</p>
                                <p class="text-xl font-black text-slate-800">{{ number_format($totalAset ?? 1830, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    <span class="text-[9px] text-emerald-600 font-semibold">Aktif</span>
                                </div>
                            </div>
                            <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-xl shadow-sm">
                                <p class="text-[10px] text-emerald-600 font-bold mb-1">Tersedia</p>
                                <p class="text-xl font-black text-slate-800">{{ number_format($asetBaik ?? 1750, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-[9px] text-emerald-600 font-semibold">Baik</span>
                                </div>
                            </div>
                            <div class="bg-amber-50 border border-amber-100 p-3 rounded-xl shadow-sm">
                                <p class="text-[10px] text-amber-600 font-bold mb-1">Dipinjam</p>
                                <p class="text-xl font-black text-slate-800">{{ number_format($peminjamanAktif ?? 2, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    <span class="text-[9px] text-amber-600 font-semibold">Aktif</span>
                                </div>
                            </div>
                        </div>
                        <!-- Progress -->
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 shimmer-line mb-4 shadow-sm">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs font-bold text-slate-600">Pemeliharaan Bulan Ini</p>
                                <span class="text-xs font-black text-sky-600">{{ $persentasePemeliharaan ?? 85 }}%</span>
                            </div>
                            <div class="h-2 bg-slate-200 rounded-full overflow-hidden mb-2">
                                <div class="h-full rounded-full progress-animated" id="heroProgressBar"
                                     style="--target-width: {{ $persentasePemeliharaan ?? 85 }}%; background: linear-gradient(90deg, #0284c7, #38bdf8);">
                                </div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-500 font-bold">
                                <span>Selesai ({{ $persentasePemeliharaan ?? 85 }}%)</span>
                                <span>Target: 100%</span>
                            </div>
                        </div>
                        <!-- Chart Bars -->
                        <div class="flex items-end gap-1.5 h-12">
                            @php $bars = [40,65,50,80,60,90,70,55,85,75,95,65]; $barColors = ['bg-sky-400','bg-blue-500','bg-cyan-400','bg-sky-500','bg-cyan-500','bg-blue-600','bg-sky-500','bg-blue-400','bg-cyan-500','bg-sky-400','bg-blue-500','bg-cyan-400']; @endphp
                            @foreach($bars as $i => $h)
                                <div class="flex-1 rounded-t-sm {{ $barColors[$i] }} opacity-80 hover:opacity-100 transition-opacity" style="height: {{ $h }}%;"></div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-slate-400 text-center mt-1.5 font-bold">Aktivitas 12 Bulan Terakhir</p>
                    </div>
                </div>
                <!-- Floating Notification -->
                <div class="float-card-2 absolute -bottom-4 -left-8 bg-white border border-slate-100 rounded-2xl p-4 shadow-xl shadow-slate-200/50 w-56">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-slate-800 text-xs font-black">Peminjaman Disetujui</p>
                            <p class="text-slate-500 text-[10px] mt-0.5 font-medium">Laptop ASUS - Ruang Rapat</p>
                            <p class="text-emerald-600 text-[10px] mt-0.5 font-bold">Baru saja</p>
                        </div>
                    </div>
                </div>
                <!-- Floating Stat Badge -->
                <div class="float-card absolute -top-4 -right-4 bg-white border border-slate-100 rounded-2xl p-4 shadow-xl shadow-slate-200/50">
                    <p class="text-slate-500 text-[10px] font-bold mb-1">Ruangan Terdaftar</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($totalRuangan ?? 4, 0, ',', '.') }}</p>
                    <div class="flex gap-1 mt-2">
                        @for($i=0;$i<5;$i++)
                            <div class="h-1.5 rounded-full {{ $i < 4 ? 'bg-sky-500' : 'bg-slate-200' }} flex-1"></div>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 w-full pointer-events-none overflow-hidden" style="line-height:0">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%">
            <path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,40 1440,30 L1440,60 L0,60 Z" fill="#ffffff" opacity="1"/>
        </svg>
    </div>
</section>
