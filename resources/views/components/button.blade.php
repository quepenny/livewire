<{{ $tag }}
    @class([
        $attributes->get('class'),
        "relative {$resolvedVariant['text']} $rounding $textSize flex items-center justify-center $font font-medium transition cursor-pointer",
        "{$resolvedVariant['disabledBackground']} {$resolvedVariant['disabledBorder']} {$resolvedVariant['disabledText']} disabled:cursor-not-allowed disabled:shadow-none group-disabled:hidden",
        "{$resolvedVariant['background']} $padding group overflow-hidden shadow-lg border-2 {$resolvedVariant['border']} {$resolvedVariant['hoverText']} focus:outline-none focus:ring-2 focus:ring-offset-2 {$resolvedVariant['focusRing']}" => !$hideBackground,
    ])

    {{ $attributes->except('class') }}

    @isset($action)
        wire:click.prevent="{{ $action }}"
        wire:loading.attr="disabled"
        wire:key="{{ $action }}"
        wire:target="{{ $action }}"
    @endisset

    @if($link)
        href="{{ $link }}"
    @else
        type="button"
    @endif
>
    @unless($hideBackground)
        <div
            @class([
                "{$resolvedVariant['hoverBackground']} absolute top-0 left-0 transform -translate-y-full h-full w-full transition-transform ease-in-out duration-200",
                'group-hover:translate-y-0' => $link,
                'group-hover:group-enabled:translate-y-0' => !$link,
            ])
        ></div>
    @endunless

    <span class="relative z-10 flex items-center justify-center">
        @if($icon)
            <x-icon
                @class(['mr-2' => $slot->isNotEmpty()])
                :name="$icon"
                :width="$iconSize"
                :height="$iconSize"
            />
        @endif

        {{ $slot }}
    </span>
</{{ $tag }}>
