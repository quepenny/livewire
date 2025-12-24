<x-input.wrapper
    :$disabled
    :$errorFor
    :$help
    :$inputAttributes
    :$label
    :$required
    :$type
>
    <input
        wire:model{{ $live ? '.live' : '' }}{{ $change ? '.change' : '' }}="{{ $field }}"
        name="{{ $field }}"
        type="{{ $type }}"
        class="{{ $inputClasses }}"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $attributes->only($inputAttributes) }}
        @if($disabled) disabled="disabled" @endif
    />
</x-input.wrapper>
