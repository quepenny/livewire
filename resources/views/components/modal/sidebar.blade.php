@props([
    'flag' => 'showMobileMenu',
    'toggle' => 'toggleMobileMenu'
])

<aside
    x-cloak
    x-show="{{ $flag }}"
    class="fixed top-0 left-0 bottom-0 w-5/6 max-w-sm z-50"
>
    {{-- Backdrop --}}
    <div
        class="fixed inset-0 bg-gray-800 opacity-25"
        @click="{{ $toggle }}"
    ></div>

    <div class="relative flex flex-col py-6 px-4 w-full h-full bg-white border-r overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <x-logo/>

            <button @click="{{ $toggle }}">
                <x-bs-icon
                    name="x"
                    class="text-gray-400 cursor-pointer hover:text-gray-500"
                />
            </button>
        </div>

        {{ $slot }}
    </div>
</aside>