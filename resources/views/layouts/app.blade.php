<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-8 mb-12">
                        <!-- Logos & Description -->
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <img src="{{ asset('storage/images/LOGO KEMENTERIAN White.png') }}" alt="Kemenperin" class="h-10 object-contain opacity-90">
                                <div class="w-px h-10 bg-slate-700"></div>
                                <img src="{{ asset('storage/images/Logo BDI Padang horizontal (NEW).png') }}" alt="BDI Padang" class="h-10 object-contain filter brightness-0 invert opacity-90">
                            </div>
                            <p class="text-slate-400 text-sm leading-relaxed pr-4">
                                Sistem Informasi Manajemen Barang Milik Negara (SIM BMN) dikembangkan untuk memberikan solusi digital terpadu dalam pencatatan, pemeliharaan, dan pelaporan aset negara di lingkungan Balai Diklat Industri Padang.
                            </p>
                        </div>
                        
                        <!-- Contact Info -->
                        <div class="md:pl-12">
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
    </body>
</html>
