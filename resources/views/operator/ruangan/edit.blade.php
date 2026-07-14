<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('operator.ruangan.update', $ruangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <x-input-label for="nama_ruangan" value="Nama Ruangan *" />
                        <x-text-input id="nama_ruangan" name="nama_ruangan" type="text" class="mt-1 block w-full" :value="old('nama_ruangan', $ruangan->nama_ruangan)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_ruangan')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="keterangan" value="Keterangan (Opsional)" />
                        <textarea id="keterangan" name="keterangan" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('keterangan', $ruangan->keterangan) }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('operator.ruangan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
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
