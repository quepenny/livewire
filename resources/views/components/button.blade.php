@props([
    'action' => null,
    'destructiveActionButton' => false,
    'showColor' => true,
    'icon' => '',
    'iconSize' => 16,
    'link' => '',
    'padding' => 'py-2 px-4',
])

@php
    $tag = $link ? 'a' : 'button';
@endphp

<{{ $tag }}
    @class([
        $attributes->get('class') ?? 'text-white w-full',
        "flex $padding items-center rounded font-medium",
        'disabled:opacity-25 transition',
        'focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600',
        'bg-blue-600 hover:bg-blue-500' => $showColor && !$destructiveActionButton,
        'bg-red-600 text-white hover:bg-red-500' => $showColor && $destructiveActionButton,
    ])

    {{ $attributes->except('class') }}

    @isset($action)
        wire:click.prevent="{{ $action }}"
        wire:loading.attr="disabled"
        wire:key="{{ $action }}"
        wire:target="{{ $action }}"
    @endisset

    @isset($link)
        href="{{ $link }}"
    @endisset
>
    @if($icon)
        <x-bs-icon
            @class(['mr-2' => $slot->isNotEmpty()])
            :name="$icon"
            :width="$iconSize"
            :height="$iconSize"
        />
    @endif

    {{ $slot }}
</{{ $tag }}>
