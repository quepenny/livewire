<div
    x-cloak
    x-show="searching"
    class="relative w-full {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}
>
    <input
        wire:model.debounce.500ms="search"
        x-ref="searchBar"
        type="text"
        class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        autocomplete="off"
    />
    
    <div class="flex absolute inset-y-0 right-0 items-center pr-2">
        <x-icon
            name="x-lg"
            class="p-2 text-gray-500 dark:text-gray-400 cursor-pointer"
            @click="closeSearch"
        />
    </div>
</div>