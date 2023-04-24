@props([
    'empty',
    'resources',
    'resourceName',
    'searchMode' => false
])

<x-dashboard.section x-data="resourceManager">
    {{ $slot }}
    
    <div class="flex flex-wrap -m-4">
        @if($resources->isEmpty())
            @isset($empty)
                {{ $empty }}
            @else
                <x-dashboard.empty
                    :section="$resourceName"
                    :show-subtitle="!$searchMode"
                    :show-button="!$searchMode"
                    action="edit"
                />
            @endisset
        @else
            @foreach($resources as $resource)
                <x-dynamic-component
                    :component="$resourceName"
                    :resource="$resource"
                />
            @endforeach
        @endif
    </div>
    
    {{ $resources->links('components.dashboard.resources.pagination') }}
</x-dashboard.section>