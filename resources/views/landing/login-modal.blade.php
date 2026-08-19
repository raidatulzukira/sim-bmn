<div id="loginModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeLoginModal()"></div>
    <!-- Modal Box -->
    <div class="relative w-full max-w-4xl mx-4 rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/40 bg-white" id="loginModalContent">
        <div class="flex flex-col md:flex-row min-h-[400px]">
            <!-- LEFT: Brand Side -->
            <div class="hidden md:flex w-[53%] relative flex-col justify-between p-12 overflow-hidden"
                 style="background: linear-gradient(135deg, #004f80ff 0%, #b3dbfcff 100%);">
                <div class="mesh-blob absolute w-64 h-64 -top-16 -left-16 bg-white/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="mesh-blob-2 absolute w-48 h-48 bottom-0 right-0 bg-white/20 rounded-full blur-3xl pointer-events-none"></div>
                
                <img src="{{ asset('storage/images/login-bg.jpg') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-10 mix-blend-overlay">
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10 p-3 bg-white/10 backdrop-blur-md rounded-xl w-max border border-white/20">
                        <img src="{{ asset('storage/images/kemenperin-logo.png') }}" alt="Kemenperin" class="h-7 object-contain filter brightness-0 invert opacity-100">
                        <div class="h-5 w-px bg-white/30"></div>
                        <img src="{{ asset('storage/images/bdi-logo.png') }}" alt="BDI Padang" class="h-6 object-contain filter brightness-0 invert opacity-100">
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-white bg-white/20 border border-white/30 mb-5">Sistem Resmi</span>
                    <h2 class="text-3xl font-black text-white mb-4 leading-tight">Manajemen<br><span class="text-sky-200">Aset Digital</span></h2>
                    <p class="text-white/80 text-sm leading-relaxed font-medium">Platform terpadu untuk efisiensi pemantauan, pemeliharaan, dan pendataan Barang Milik Negara.</p>
                </div>
                <!-- Feature Pills -->
                <div class="relative z-10 space-y-2.5">
                    <div class="flex items-center gap-2.5 text-white/90 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Akses aman & terenkripsi
                    </div>
                    <div class="flex items-center gap-2.5 text-white/90 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Dashboard sesuai peran
                    </div>
                    <div class="flex items-center gap-2.5 text-white/90 text-sm font-medium">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        Data terpusat & laporan otomatis
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form Side -->
            <div class="w-full md:w-[47%] flex flex-col justify-center bg-white p-8 md:p-12 relative overflow-hidden">
                <!-- Close button -->
                <button onclick="closeLoginModal()" class="absolute top-4 right-4 w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="relative z-10">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex md:hidden items-center gap-2 mb-6">
                            <img src="{{ asset('storage/images/kemenperin-logo.png') }}" alt="Kemenperin" class="h-7 object-contain">
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-1.5">Selamat Datang</h3>
                        <p class="text-slate-500 text-sm font-medium">Masuk dengan akun Anda untuk ke sistem.</p>
                    </div>
                    <!-- Error -->
                    <div id="loginError" class="hidden mb-5 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="loginErrorText" class="font-bold"></span>
                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input id="email" type="email" name="email" required autofocus
                                       class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10 text-slate-900 placeholder-slate-400 text-sm font-medium transition-all"
                                       placeholder="nama@kemenperin.go.id"
                                       value="{{ old('email') }}">
                            </div>
                        </div>
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                       class="w-full pl-11 pr-12 py-3.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10 text-slate-900 placeholder-slate-400 text-sm font-medium transition-all"
                                       placeholder="••••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-sky-600 transition-colors">
                                    <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </div>
                        <!-- Remember -->
                        <div class="flex items-center gap-3">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-white text-sky-600 focus:ring-sky-500/40 cursor-pointer">
                            <label for="remember_me" class="text-sm text-slate-600 font-medium cursor-pointer select-none">Ingat saya di perangkat ini</label>
                        </div>
                        <!-- Submit -->
                        <button type="submit" class="w-full py-4 btn-glow text-white font-bold rounded-xl text-sm tracking-wide flex items-center justify-center gap-2 mt-2 shadow-lg shadow-sky-900/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk ke Sistem
                        </button>
                    </form>
                    <p class="text-slate-500 text-xs font-medium text-center mt-6 leading-relaxed">
                        <!-- Akses hanya untuk pegawai resmi Balai Diklat Industri Padang.<br> -->
                        Butuh akun? Hubungi administrator sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
