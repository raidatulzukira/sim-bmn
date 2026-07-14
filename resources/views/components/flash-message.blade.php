@if (session()->has('success') || session()->has('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition.duration.500ms
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-4 right-4 z-50 rounded-lg p-4 shadow-lg text-white max-w-sm 
         {{ session()->has('success') ? 'bg-green-500' : 'bg-red-500' }}">
        <div class="flex items-center justify-between gap-4">
            <span class="font-semibold text-sm">
                {{ session('success') ?? session('error') }}
            </span>
            <button @click="show = false" class="text-white hover:text-gray-200 focus:outline-none text-xl leading-none">
                &times;
            </button>
        </div>
    </div>
@endif
