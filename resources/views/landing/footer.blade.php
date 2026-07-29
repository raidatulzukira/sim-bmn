<footer class="bg-slate-950 border-t border-slate-900 pt-16 pb-8 relative overflow-hidden">
    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);"></div>
    <div class="absolute top-0 right-1/4 w-[300px] h-[300px] bg-sky-900/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
            <!-- Brand -->
            <div class="md:col-span-5">
                <div class="flex items-center gap-3 mb-6 p-4 bg-slate-900/50 border border-slate-800 rounded-2xl w-max shadow-sm backdrop-blur-sm">
                    <!-- Added invert to make the logo white for dark background -->
                    <img src="{{ asset('storage/images/LOGO KEMENTERIAN EPS [Converted].png') }}" alt="Kemenperin" class="h-10 object-contain filter brightness-0 invert opacity-90">
                    <div class="w-px h-10 bg-slate-700"></div>
                    <img src="{{ asset('storage/images/Logo BDI Padang horizontal (NEW).png') }}" alt="BDI Padang" class="h-10 object-contain filter brightness-0 invert opacity-90">
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 max-w-sm font-medium">
                    SIM BMN dikembangkan untuk solusi digital terpadu dalam pencatatan, pemeliharaan, dan pelaporan aset negara di lingkungan Balai Diklat Industri Padang.
                </p>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-900/30 border border-emerald-800/50 text-emerald-400 text-[11px] font-bold shadow-sm">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></div>
                        Sistem Online
                    </div>
                    <div class="text-slate-400 text-[11px] font-mono font-bold bg-slate-800/50 px-3 py-1.5 rounded-full border border-slate-700">v1.0.0</div>
                </div>
            </div>
            <!-- Quick Links -->
            <div class="md:col-span-3 md:col-start-7">
                <h4 class="text-white font-black mb-6 text-sm tracking-wider uppercase">Tautan Cepat</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Beranda</a></li>
                    <li><a href="#fitur" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Fitur Sistem</a></li>
                    <li><a href="#statistik" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Statistik</a></li>
                    <li><button onclick="openLoginModal()" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Masuk Aplikasi</button></li>
                </ul>
            </div>
            <!-- Contact -->
            <div class="md:col-span-3">
                <h4 class="text-white font-black mb-6 text-sm tracking-wider uppercase">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-900/30 border border-sky-800/50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-slate-400 text-sm leading-relaxed font-medium">Balai Diklat Industri Padang<br>Jl. Bungo Pasang, Tabing, Koto Tangah,<br>Kota Padang, Sumatera Barat 25171</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-900/30 border border-sky-800/50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <a href="mailto:bdipadang@kemenperin.go.id" class="text-slate-400 hover:text-sky-400 transition-colors text-sm font-medium">bdipadang@kemenperin.go.id</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-slate-800/60 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm font-medium">&copy; {{ date('Y') }} Kementerian Perindustrian &mdash; Balai Diklat Industri Padang.</p>
            <div class="flex items-center gap-3">
                <span class="text-slate-500 text-xs font-medium">Dikelola oleh</span>
                <span class="text-slate-300 text-xs font-bold">Subbag Tata Usaha BDI Padang</span>
            </div>
        </div>
    </div>
</footer>
