@props([
    'active' => false,
    'buttonClass' => 'flex items-center pl-3 py-3 pr-2 text-gray-50 font-medium rounded',
    'dropdown' => false,
    'icon',
    'route' => '#',
    'postRequest' => false,
    'text',
])

@if($postRequest)
<form method="POST" action="{{ $route }}">
    @csrf
    
    <button
        class="{{ $buttonClass }} hover:bg-gray-900 w-full"
        type="submit"
    >
@else
    <a
        @class([
            $buttonClass,
            'bg-teal-500' => $active,
            'hover:bg-gray-900' => !$active,
            $attributes->get('class')
        ])
        href="{{ $route }}"
    >
@endif
        
        <span class="inline-block mr-3">
            <x-icon
                :name="$icon"
                {{  $attributes->class([
                    'w-4 h-4',
                    'text-gray-400' => !$active,
                ]) }}
            />
        </span>
        
        <span>{{ $text }}</span>
        
        @if($dropdown)
            <span class="inline-block ml-auto">
                <x-icon
                    name="chevron-compact-down"
                    class="text-gray-400 w-4 h-4"
                />
            </span>
        @endif
        
@unless($postRequest)
    </a>
@else
    </button>
</form>
@endif