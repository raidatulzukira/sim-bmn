<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('operator.pengguna.update', $pengguna->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <x-input-label for="name" value="Nama Lengkap *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $pengguna->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" value="Email *" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $pengguna->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" value="Password (Kosongkan jika tidak ingin mengubah)" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="role" value="Role *" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="operator" {{ old('role', $pengguna->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="kasubag_tu" {{ old('role', $pengguna->role) == 'kasubag_tu' ? 'selected' : '' }}>Kasubag TU</option>
                            <option value="pegawai" {{ old('role', $pengguna->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="nip" value="NIP (Opsional)" />
                        <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $pengguna->nip)" />
                        <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="no_wa" value="No WhatsApp (Opsional, mulai dengan 08 atau +62)" />
                        <x-text-input id="no_wa" name="no_wa" type="text" class="mt-1 block w-full" :value="old('no_wa', $pengguna->no_wa)" />
                        <x-input-error :messages="$errors->get('no_wa')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('operator.pengguna.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
