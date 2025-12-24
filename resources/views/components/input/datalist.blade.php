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
        class="border border-gray-200 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white w-full disabled:opacity-50 disabled:cursor-not-allowed placeholder-gray-400"
        list="{{ $datalistId }}"
        name="{{ $field }}"
        type="text"
        wire:model{{ $live ? '.live' : '' }}{{ $change ? '.change' : '' }}="{{ $field }}"
        placeholder="{{ $placeholder }}"
        @if($disabled) disabled="disabled" @endif
    />

    <datalist id="{{ $datalistId }}">
        @unless($slot->isEmpty())
            {{ $slot }}
        @else
            @foreach($options as $option)
                <option
                    wire:key="{{ $option }}"
                    value="{{ $option }}"
                ></option>
            @endforeach
        @endunless
    </datalist>
</x-input.wrapper>
