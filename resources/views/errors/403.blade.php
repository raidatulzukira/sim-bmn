<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center pt-8 sm:justify-start sm:pt-0">
                <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                    403
                </div>
                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                    Forbidden
                </div>
            </div>
            
            <div class="mt-4 text-gray-600">
                {{ $exception->getMessage() ?: 'Anda tidak memiliki akses ke halaman ini.' }}
            </div>

            <div class="mt-6">
                @auth
                    @php
                        $role = auth()->user()->role;
                        $dashboardRoute = match($role) {
                            'operator' => route('operator.dashboard'),
                            'kasubag_tu' => route('kasubag.dashboard'),
                            'pegawai' => route('pegawai.dashboard'),
                            default => url('/'),
                        };
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Kembali ke Beranda
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
