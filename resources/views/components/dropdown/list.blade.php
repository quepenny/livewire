<div
    x-data="dropdown"
    {{ $attributes->merge(['class' => 'relative'])->except('') }}
>
    @isset($toggle)
        {{ $toggle }}
    @else
        <button @click.stop="toggleDropdown">
            <x-icon
                name="three-dots-vertical"
                class="ml-auto h-4 w-4"
            />
        </button>
    @endisset

    <div
        x-cloak
        x-show="showDropdown"
        @class([
            'origin-top-right right-0 absolute mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-10',
            $attributes->get('class-list')
        ])
        @click.outside="toggleDropdown"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="menu-button"
        tabindex="-1"
    >
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>
