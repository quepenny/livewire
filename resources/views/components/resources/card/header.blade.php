<div class="flex mb-2" {{ $attributes }}>
    <span class="inline-block mr-2">
        <x-icon
            :name="$icon ?? 'calendar-week'"
            class="text-gray-400"
            :width="16"
            :height="16"
        />
    </span>
    
    <h3 class="text-xs text-gray-600">
        {{ $status }}
    </h3>

    <x-dropdown.list class="ml-auto">
        {{ $slot }}
    </x-dropdown.list>
</div>