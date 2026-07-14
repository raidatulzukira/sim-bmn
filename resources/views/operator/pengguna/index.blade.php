<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pengguna') }}
            </h2>
            <a href="{{ route('operator.pengguna.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">
                Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter & Search -->
            <div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6">
                <form method="GET" action="{{ route('operator.pengguna.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-text-input name="search" value="{{ request('search') }}" class="w-full" placeholder="Cari nama atau email..." />
                    </div>
                    <div>
                        <select name="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-auto">
                            <option value="">Semua Role</option>
                            <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="kasubag_tu" {{ request('role') == 'kasubag_tu' ? 'selected' : '' }}>Kasubag TU</option>
                            <option value="pegawai" {{ request('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Cari</x-primary-button>
                        <a href="{{ route('operator.pengguna.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No WA</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->role === 'operator' ? 'bg-red-100 text-red-800' : ($user->role === 'kasubag_tu' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->no_wa ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('operator.pengguna.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('operator.pengguna.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
