<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM BMN - Balai Diklat Industri Padang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS if Vite isn't running properly -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Animation Classes */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }

        /* Blob Animation for Hero */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="glass shadow-sm sticky top-0 z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-[80px] items-center">
                <div class="flex items-center gap-4">
                    <!-- Logos -->
                    <div class="flex items-center gap-4 border-r border-slate-200 pr-5">
                        <img src="{{ asset('storage/images/LOGO KEMENTERIAN EPS [Converted].png') }}" alt="Kemenperin" class="h-11 object-contain">
                        <div class="h-8 w-px bg-slate-300"></div>
                        <img src="{{ asset('storage/images/Logo BDI Padang horizontal (NEW).png') }}" alt="BDI Padang" class="h-10 object-contain">
                    </div>
                    <div class="hidden sm:flex flex-col pl-1">
                        <span class="font-extrabold text-xl text-slate-900 tracking-tight leading-none">SIM <span class="text-blue-600">BMN</span></span>
                    </div>
                </div>
                
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                    <a href="#fitur" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Fitur Sistem</a>
                    <a href="#statistik" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Statistik</a>
                </div>
                
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition-all shadow-md hover:shadow-blue-600/30 hover:-translate-y-0.5">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 text-blue-600 font-semibold hover:text-blue-700 transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-950 font-bold rounded-full hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-md hover:shadow-yellow-500/30 hover:-translate-y-0.5 hidden sm:inline-block">Daftar Akun</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-12 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
        <!-- Animated Blobs Background -->
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob z-0 pointer-events-none"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000 z-0 pointer-events-none"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-4000 z-0 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Text Content -->
                <div class="text-center lg:text-left animate-on-scroll">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-700 font-semibold text-sm mb-6 border border-blue-100 shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                        </span>
                        Sistem Informasi Manajemen Aset
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold text-slate-900 leading-[1.15] mb-6 tracking-tight">
                        Transformasi Digital Pengelolaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500">Barang Milik Negara</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        Platform resmi Balai Diklat Industri Padang untuk memonitor, mencatat, dan mengelola seluruh aset negara secara akurat, terstruktur, dan real-time.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="group px-8 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2">
                                    Akses Dashboard
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="group px-8 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2">
                                    Masuk ke Sistem
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endauth
                        @endif
                        <a href="#fitur" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-full hover:bg-slate-50 transition-all duration-300 shadow-md border border-slate-200 flex items-center justify-center hover:-translate-y-0.5">
                            Lihat Modul
                        </a>
                    </div>
                </div>

                <!-- Dashboard Preview Animation -->
                <div class="relative hidden lg:block animate-on-scroll delay-200">
                    <div class="glass border border-white/80 shadow-2xl rounded-3xl p-2 transform hover:scale-[1.01] transition-transform duration-500">
                        <div class="bg-white rounded-[1.25rem] overflow-hidden border border-slate-100">
                            <!-- Fake Browser Header -->
                            <div class="bg-slate-50 px-4 py-3 border-b border-slate-100 flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                <div class="mx-auto bg-white border border-slate-200 rounded-md text-[10px] px-3 py-1 text-slate-400 font-medium font-mono flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    sim-bmn.bdipadang.id
                                </div>
                            </div>
                            
                            <!-- Fake Dashboard Content -->
                            <div class="p-6 bg-slate-50/50">
                                <div class="flex justify-between items-end mb-6">
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-lg">Dashboard</h3>
                                        <p class="text-xs text-slate-500">Ringkasan aset Balai Diklat Industri Padang</p>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs border border-blue-200">OP</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Animated card -->
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 group hover:border-blue-300 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Total Aset Tercatat</p>
                                        <p class="text-2xl font-black text-slate-800">4,521</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 group hover:border-green-300 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mb-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium mb-1">Kondisi Baik</p>
                                        <p class="text-2xl font-black text-slate-800">4,198</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm relative overflow-hidden">
                                    <!-- Progress bar animation -->
                                    <div class="absolute top-0 left-0 w-full h-1 bg-slate-100">
                                        <div class="h-full bg-blue-500 animate-[pulse_3s_ease-in-out_infinite]" style="width: 75%"></div>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700 mb-3 mt-1">Status Pemeliharaan Bulan Ini</p>
                                    <div class="space-y-3">
                                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-green-500 w-[60%]"></div>
                                        </div>
                                        <div class="flex justify-between text-[10px] text-slate-500 font-medium">
                                            <span>Selesai (60%)</span>
                                            <span>Target: 100%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <!-- Statistik Section (Animated Counters) -->
    <section id="statistik" class="py-16 bg-blue-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-blue-500/50">
                <div class="animate-on-scroll">
                    <p class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="4521">0</p>
                    <p class="text-blue-200 font-medium text-sm md:text-base">Total Aset BMN</p>
                </div>
                <div class="animate-on-scroll delay-100">
                    <p class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="150">0</p>
                    <p class="text-blue-200 font-medium text-sm md:text-base">Ruangan/Lokasi</p>
                </div>
                <div class="animate-on-scroll delay-200">
                    <p class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="86">0</p>
                    <p class="text-blue-200 font-medium text-sm md:text-base">Peminjaman Aktif</p>
                </div>
                <div class="animate-on-scroll delay-300">
                    <p class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="12">0</p>
                    <p class="text-blue-200 font-medium text-sm md:text-base">Sedang Dipelihara</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Utama Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-on-scroll">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm mb-2 block">Modul Sistem</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6">Fungsi Utama SIM BMN</h2>
                <p class="text-slate-600 text-lg">Mendukung siklus penuh pengelolaan aset mulai dari pencatatan, peminjaman, pemeliharaan, hingga pelaporan sesuai standar.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Modul 1 -->
                <div class="p-8 rounded-3xl bg-slate-100 border border-slate-100 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-300 group animate-on-scroll delay-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pencatatan Aset</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Input data aset dengan formulir lengkap (merk, kondisi, nilai, lokasi). Dilengkapi fitur QR Code untuk pelabelan fisik.</p>
                </div>
                
                <!-- Modul 2 -->
                <div class="p-8 rounded-3xl bg-slate-100 border border-slate-100 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-300 group animate-on-scroll delay-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Sirkulasi Peminjaman</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Pegawai dapat mengajukan peminjaman barang inventaris. Operator dapat menyetujui dan memantau status pengembalian.</p>
                </div>
                
                <!-- Modul 3 -->
                <div class="p-8 rounded-3xl bg-slate-100 border border-slate-100 hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-300 group animate-on-scroll delay-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pemeliharaan Terjadwal</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Catat riwayat perbaikan, jadwalkan perawatan rutin, dan laporkan kerusakan barang dengan bukti foto.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
                <div class="md:col-span-5">
                    <div class="flex items-center gap-4 mb-6 bg-white/5 p-4 rounded-2xl border border-white/10 w-max">
                        <!-- Logos in Footer -->
                        <img src="{{ asset('storage/images/LOGO KEMENTERIAN White.png') }}" alt="Kemenperin" class="h-10 object-contain opacity-90">
                        <div class="w-px h-10 bg-slate-700"></div>
                        <img src="{{ asset('storage/images/Logo BDI Padang horizontal (NEW).png') }}" alt="BDI Padang" class="h-10 object-contain filter brightness-0 invert opacity-90">
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6 pr-4">
                        Sistem Informasi Manajemen Barang Milik Negara (SIM BMN) dikembangkan untuk memberikan solusi digital terpadu dalam pencatatan, pemeliharaan, dan pelaporan aset negara di lingkungan Balai Diklat Industri Padang.
                    </p>
                </div>
                
                <div class="md:col-span-3 md:col-start-7">
                    <h4 class="text-white font-bold mb-5 tracking-wide">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-blue-400 transition-colors flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Fitur Sistem</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Masuk Aplikasi</a></li>
                    </ul>
                </div>
                
                <div class="md:col-span-3">
                    <h4 class="text-white font-bold mb-5 tracking-wide">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Balai Diklat Industri Padang<br/>Jl. Bungo Pasang, Tabing, Koto Tangah, Kota Padang, Sumatera Barat 25171</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:bdipadang@kemenperin.go.id" class="hover:text-white transition-colors">bdipadang@kemenperin.go.id</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} Kementerian Perindustrian - Balai Diklat Industri Padang.
                </div>
                <div class="text-slate-600 text-sm bg-slate-800/50 px-3 py-1 rounded-full font-mono">
                    SIM BMN v1.0.0
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Intersection Observer for Scroll Animations
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        
                        // If it's a counter, start counting
                        if(entry.target.querySelector('.counter')) {
                            startCounters(entry.target);
                        }
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach((el) => {
                observer.observe(el);
            });

            // 2. Animated Counter function
            function startCounters(container) {
                const counters = container.querySelectorAll('.counter');
                const speed = 200; // lower is slower

                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText.replace(/,/g, '');
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc).toLocaleString('id-ID');
                            setTimeout(updateCount, 15);
                        } else {
                            counter.innerText = target.toLocaleString('id-ID');
                        }
                    };
                    updateCount();
                });
            }

            // 3. Navbar scroll effect
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md');
                    navbar.classList.remove('shadow-sm');
                } else {
                    navbar.classList.remove('shadow-md');
                    navbar.classList.add('shadow-sm');
                }
            });
        });
    </script>
</body>
</html>
