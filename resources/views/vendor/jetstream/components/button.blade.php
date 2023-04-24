@props([
    'action' => null,
    'destructiveActionButton' => false,
    'showColor' => true,
])

<button
    @class([
        $attributes->get('class') ?? 'flex items-center py-2 px-4 rounded text-white text-sm font-medium',
        'disabled:opacity-25 transition',
        'bg-teal-500 hover:bg-teal-600' => $showColor && !$destructiveActionButton,
        'bg-red-500 hover:bg-red-600' => $showColor && $destructiveActionButton,
    ])
    
    {{ $attributes->except('class') }}
    
    @isset($action)
        wire:click.prevent="{{ $action }}"
        wire:loading.attr="disabled"
        wire:key="{{ $action }}"
        wire:target="{{ $action }}"
    @endisset
>
    {{ $slot }}
</button>
