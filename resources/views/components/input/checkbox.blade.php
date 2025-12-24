<x-input.wrapper
    :$disabled
    :$errorFor
    :$help
    :$inputAttributes
    :$label
    :$required
    :$type
>
    <div class="flex items-center gap-2">
        <input
            wire:model{{ $live ? '.live' : '' }}{{ $change ? '.change' : '' }}="{{ $field }}"
            name="{{ $field }}"
            type="checkbox"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder ?? '' }}"
            {{ $attributes->only($inputAttributes) }}
            @if($disabled) disabled="disabled" @endif
        />

        {{ $slot }}
    </div>
</x-input.wrapper>
