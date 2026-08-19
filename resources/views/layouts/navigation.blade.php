<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-sky-100 shadow-sm sticky top-0 z-50">
    @php
        $role = Auth::user()->role;
        $dashboardRoute = $role === 'operator' ? 'operator.dashboard' : ($role === 'kasubag_tu' ? 'kasubag.dashboard' : 'pegawai.dashboard');
        $profileRoute = $role === 'operator' ? 'operator.profile.edit' : ($role === 'kasubag_tu' ? 'kasubag.profile.edit' : 'pegawai.profile.edit');
    @endphp
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-4 hover:opacity-90 transition-opacity">
                        <div class="flex items-center gap-3 border-r border-slate-200 pr-4">
                            <img src="{{ asset('storage/images/kemenperin-logo.png') }}" alt="Kemenperin" class="h-9 object-contain">
                            <div class="h-6 w-px bg-slate-300"></div>
                            <img src="{{ asset('storage/images/bdi-logo.png') }}" alt="BDI Padang" class="h-8 object-contain">
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="font-black text-lg text-slate-900 tracking-tight leading-none">SIM <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-500 to-blue-600">BMN</span></span>
                            <span class="text-[10px] text-slate-500 tracking-widest uppercase font-bold">Balai Diklat Industri</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-15 sm:-my-px sm:ms-20 sm:flex">
                    <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if ($role === 'operator')
                        <!-- Master Data Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-blue-600 focus:outline-none transition ease-in-out duration-150 h-full mt-1">
                                        <div>{{ __('Master Data') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('operator.pengguna.index')" :active="request()->routeIs('operator.pengguna.*')">
                                        {{ __('Kelola Pengguna') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('operator.aset.index')" :active="request()->routeIs('operator.aset.*')">
                                        {{ __('Kelola Aset BMN') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('operator.ruangan.index')" :active="request()->routeIs('operator.ruangan.*')">
                                        {{ __('Kelola Ruangan') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Transaksi Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-blue-600 focus:outline-none transition ease-in-out duration-150 h-full mt-1">
                                        <div>{{ __('Transaksi') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('operator.peminjaman.index')" :active="request()->routeIs('operator.peminjaman.*')">
                                        {{ __('Kelola Peminjaman') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('operator.pemeliharaan.index')" :active="request()->routeIs('operator.pemeliharaan.*')">
                                        {{ __('Kelola Pemeliharaan') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-nav-link :href="route('operator.laporan.index')" :active="request()->routeIs('operator.laporan.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @elseif ($role === 'kasubag_tu')
                        <!-- Master Data Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-blue-600 focus:outline-none transition ease-in-out duration-150 h-full mt-1">
                                        <div>{{ __('Master Data') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('kasubag.aset.index')" :active="request()->routeIs('kasubag.aset.*')">
                                        {{ __('Data Aset') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('kasubag.ruangan.index')" :active="request()->routeIs('kasubag.ruangan.*')">
                                        {{ __('Data Ruangan') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Persetujuan Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-blue-600 focus:outline-none transition ease-in-out duration-150 h-full mt-1">
                                        <div>{{ __('Persetujuan') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('kasubag.persetujuan.index')" :active="request()->routeIs('kasubag.persetujuan.*')">
                                        {{ __('Approval Peminjaman') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('kasubag.persetujuan_pemeliharaan.index')" :active="request()->routeIs('kasubag.persetujuan_pemeliharaan.*')">
                                        {{ __('Approval Pemeliharaan') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Laporan -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-nav-link :href="route('kasubag.laporan.index')" :active="request()->routeIs('kasubag.laporan.*')">
                                {{ __('Laporan') }}
                            </x-nav-link>
                        </div>
                    @elseif ($role === 'pegawai')
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-nav-link :href="route('pegawai.katalog_aset.index')" :active="request()->routeIs('pegawai.katalog_aset.*')">
                            {{ __('Data Aset') }}
                        </x-nav-link>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-nav-link :href="route('pegawai.peminjaman.index')" :active="request()->routeIs('pegawai.peminjaman.*')">
                            {{ __('Peminjaman Aset') }}
                        </x-nav-link>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-nav-link :href="route('pegawai.laporan_kerusakan.index')" :active="request()->routeIs('pegawai.laporan_kerusakan.*')">
                            {{ __('Kerusakan Aset') }}
                        </x-nav-link>
                        </div>
                    @endif
                </div>
            </div>

            @if ($role === 'pegawai')
                <!-- Keranjang Icon -->
                <div class="hidden sm:flex sm:items-center sm:ms-auto">
                    <a href="{{ route('pegawai.keranjang.index') }}" class="relative p-2 text-slate-400 hover:text-sky-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @php
                            $cartCount = \App\Models\KeranjangPeminjaman::where('user_id', auth()->id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-1 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/4 bg-rose-500 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            @endif

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center {{ $role === 'pegawai' ? 'sm:ms-6' : 'sm:ms-36' }}">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-blue-600 focus:outline-none transition ease-in-out duration-150">
                            @php
                                $emailInitial = strtoupper(substr(Auth::user()->email, 0, 1));
                            @endphp
                            <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shadow-sm border border-blue-200">
                                {{ $emailInitial }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route($profileRoute)">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if ($role === 'operator')
                <x-responsive-nav-link :href="route('operator.pengguna.index')" :active="request()->routeIs('operator.pengguna.*')">
                    {{ __('Kelola Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('operator.aset.index')" :active="request()->routeIs('operator.aset.*')">
                    {{ __('Kelola Aset BMN') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('operator.ruangan.index')" :active="request()->routeIs('operator.ruangan.*')">
                    {{ __('Kelola Ruangan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('operator.peminjaman.index')" :active="request()->routeIs('operator.peminjaman.*')">
                    {{ __('Kelola Peminjaman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('operator.pemeliharaan.index')" :active="request()->routeIs('operator.pemeliharaan.*')">
                    {{ __('Kelola Pemeliharaan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('operator.laporan.index')" :active="request()->routeIs('operator.laporan.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @elseif ($role === 'kasubag_tu')
                <x-responsive-nav-link :href="route('kasubag.aset.index')" :active="request()->routeIs('kasubag.aset.*')">
                    {{ __('Data Aset') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasubag.ruangan.index')" :active="request()->routeIs('kasubag.ruangan.*')">
                    {{ __('Data Ruangan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasubag.persetujuan.index')" :active="request()->routeIs('kasubag.persetujuan.*')">
                    {{ __('Approval Peminjaman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasubag.persetujuan_pemeliharaan.index')" :active="request()->routeIs('kasubag.persetujuan_pemeliharaan.*')">
                    {{ __('Approval Pemeliharaan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasubag.laporan.index')" :active="request()->routeIs('kasubag.laporan.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @elseif ($role === 'pegawai')
                <x-responsive-nav-link :href="route('pegawai.katalog_aset.index')" :active="request()->routeIs('pegawai.katalog_aset.*')">
                    {{ __('Katalog Aset') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pegawai.peminjaman.index')" :active="request()->routeIs('pegawai.peminjaman.*')">
                    {{ __('Peminjaman Aset') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pegawai.laporan_kerusakan.index')" :active="request()->routeIs('pegawai.laporan_kerusakan.*')">
                    {{ __('Laporan Kerusakan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route($profileRoute)">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
