<x-input.wrapper
    :$disabled
    :$errorFor
    :$help
    :$inputAttributes
    :$label
    :$required
    :$type
>
    <textarea
        wire:model{{ $live ? '.live' : '' }}{{ $change ? '.change' : '' }}="{{ $field }}"
        name="{{ $field }}"
        class="{{ $inputClasses }}"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $attributes->only($inputAttributes) }}
        @if($disabled) disabled="disabled" @endif
    ></textarea>
</x-input.wrapper>
