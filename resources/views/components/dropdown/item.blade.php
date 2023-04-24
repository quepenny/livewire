<div {{ $attributes }}>
    @isset($route)
        <a
            href="{{ $route }}"
            @click.stop
            class="text-gray-700 text-left sm:text-right block px-4 py-2 text-sm hover:bg-gray-200"
            role="menuitem"
            tabindex="-1"
        >{{ $label }}</a>
    @else
        <button
            @isset($action) wire:click="{{ $action }}" @endisset
            @click.stop="selectItem"
            class="text-gray-700 text-left w-full sm:text-right block px-4 py-2 text-sm hover:bg-gray-200"
            role="menuitem"
            tabindex="-1"
        >{{ $label }}</button>
    @endisset
</div>
