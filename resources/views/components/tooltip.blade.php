<x-tag
    :tag="$tag"
    data-tooltip-target="tooltip-{{ $key }}"
    data-tooltip-placement="{{ $placement }}"
    {{ $attributes }}
>
    {{ $slot }}

    <div
        id="tooltip-{{ $key }}"
        role="tooltip"
        class="tooltip inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-gray-700"
    >
        {{ $message }}
        
        <div
            class="tooltip-arrow"
             data-popper-arrow
        ></div>
    </div>
</x-tag>

