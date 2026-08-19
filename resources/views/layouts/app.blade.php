<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo-server.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- jQuery & Select2 for Searchable Dropdowns -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <style>
            /* Custom Select2 Tailwind Styling */
            .select2-container .select2-selection--single {
                height: 46px !important;
                border-radius: 0.75rem !important;
                border: 1px solid #e2e8f0 !important;
                display: flex;
                align-items: center;
                padding-left: 0.5rem;
                background-color: #fff !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 44px !important;
                right: 10px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #334155 !important;
                line-height: normal !important;
            }
            .select2-search__field {
                border-radius: 0.5rem !important;
                padding: 0.5rem !important;
                outline: none !important;
                border: 1px solid #cbd5e1 !important;
            }
            .select2-search__field:focus {
                border-color: #0ea5e9 !important;
                box-shadow: 0 0 0 1px #0ea5e9 !important;
            }
            .select2-dropdown {
                border-radius: 0.75rem !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
                overflow: hidden;
                margin-top: 4px;
            }
            .select2-results__option {
                padding: 8px 16px !important;
                font-size: 0.875rem;
            }
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #0ea5e9 !important;
                color: white !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-sky-100 flex flex-col">
            @include('layouts.navigation')

            <x-flash-message />

            <!-- Page Heading -->
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @else
                @hasSection('header')
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('header')
                        </div>
                    </header>
                @endif
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <!-- Footer -->
            <footer class="bg-slate-950 border-t border-slate-900 pt-16 pb-8 relative overflow-hidden mt-auto">
                <!-- Subtle Background Elements -->
                <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);"></div>
                <div class="absolute top-0 right-1/4 w-[300px] h-[300px] bg-sky-900/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
                        <!-- Brand -->
                        <div class="md:col-span-5">
                            <div class="flex items-center gap-3 mb-6 p-4 bg-slate-900/50 border border-slate-800 rounded-2xl w-max shadow-sm backdrop-blur-sm">
                                <img src="{{ asset('storage/images/kemenperin-logo.png') }}" alt="Kemenperin" class="h-10 object-contain filter brightness-0 invert opacity-90">
                                <div class="w-px h-10 bg-slate-700"></div>
                                <img src="{{ asset('storage/images/bdi-logo.png') }}" alt="BDI Padang" class="h-10 object-contain filter brightness-0 invert opacity-90">
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

                        <!-- Quick Links (Dynamic) -->
                        <div class="md:col-span-3 md:col-start-7">
                            <h4 class="text-white font-black mb-6 text-sm tracking-wider uppercase">Menu Utama</h4>
                            <ul class="space-y-3">
                                @php
                                    $role = Auth::user()->role;
                                @endphp
                                
                                @if($role === 'operator')
                                    <li><a href="{{ route('operator.dashboard') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Dashboard</a></li>
                                    <li><a href="{{ route('operator.aset.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Kelola Aset BMN</a></li>
                                    <li><a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Kelola Peminjaman</a></li>
                                    <li><a href="{{ route('operator.pemeliharaan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Kelola Pemeliharaan</a></li>
                                    <li><a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Laporan</a></li>
                                @elseif($role === 'kasubag_tu')
                                    <li><a href="{{ route('kasubag.dashboard') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Dashboard</a></li>
                                    <li><a href="{{ route('kasubag.aset.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Data Aset BMN</a></li>
                                    <li><a href="{{ route('kasubag.persetujuan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Persetujuan Peminjaman</a></li>
                                    <li><a href="{{ route('kasubag.persetujuan_pemeliharaan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Persetujuan Pemeliharaan</a></li>
                                    <li><a href="{{ route('kasubag.laporan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Laporan</a></li>
                                @elseif($role === 'pegawai')
                                    <li><a href="{{ route('pegawai.dashboard') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Dashboard</a></li>
                                    <li><a href="{{ route('pegawai.katalog_aset.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Katalog Aset</a></li>
                                    <li><a href="{{ route('pegawai.peminjaman.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Peminjaman Aset</a></li>
                                    <li><a href="{{ route('pegawai.laporan_kerusakan.index') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-sky-400 transition-colors text-sm group font-medium"><svg class="w-4 h-4 text-sky-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Laporan Kerusakan</a></li>
                                @endif
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
        </div>
        <!-- Initialize Select2 -->
        <script>
            $(document).ready(function() {
                $('select').select2({
                    width: '100%',
                    placeholder: function(){
                        $(this).data('placeholder');
                    }
                });

                // Listen for Livewire updates or DOM changes to reinitialize if needed
                // Select2 doesn't auto-init on dynamically added elements
            });
        </script>
        @stack('scripts')
    </body>
</html>
