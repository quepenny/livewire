<x-input.wrapper
    :$disabled
    :$errorFor
    :$help
    :$inputAttributes
    :$label
    :$required
    :$type
>
    <select
        wire:model{{ $live ? '.live' : '' }}{{ $change ? '.change' : '' }}="{{ $field }}"
        name="{{ $field }}"
        {{ $attributes->only($inputAttributes) }}
        class="{{ $inputClasses }}"
        @if($disabled) disabled="disabled" @endif
    >
        @unless($slot->isEmpty())
            {{ $slot }}
        @else
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $option)
                <option value="{{ $option['value'] }}">
                    {{ $option['label'] }}
                </option>
            @endforeach
        @endunless
    </select>
</x-input.wrapper>
