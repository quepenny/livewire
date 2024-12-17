<div
    @class([
        $attributes->get('class'),
        'mb-3' => !$slim
    ])
    {{ $attributes->except($inputAttrs) }}
>
    @if($showLabel)
        <label
            class="text-gray-700 text-sm font-bold"
            for="username"
        >
            {{ $label ?? __(ucfirst($field)) }}

            @if($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <div
        @class([
            'mt-2' => !$slim,
            'inline-block' => $type === 'checkbox'
        ])
    >
        @switch($type)
            @case('select')
                <select
                    wire:model{{ $live ? '.live' : '' }}{{ $blur ? '.blur' : '' }}="{{ $field }}"
                    name="{{ $field }}"
                    {{ $attributes->only($inputAttrs) }}
                    class="{{ $inputClasses }}"
                    @if($isDisabled) disabled="disabled" @endif
                >
                    <option value="">{{ $placeholder ?? __('Select') }}</option>

                    @foreach($options as $option)
                        <option value="{{ $option['value'] }}">
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
                @break

            @case('textarea')
                <textarea
                    wire:model{{ $live ? '.live' : '' }}{{ $blur ? '.blur' : '' }}="{{ $field }}"
                    name="{{ $field }}"
                    {{ $attributes->only($inputAttrs) }}
                    placeholder="{{ $placeholder ?? '' }}"
                    @class([$inputClasses, 'h-24'])
                    @if($isDisabled) disabled="disabled" @endif
                ></textarea>
                @break

            @case('custom')
                {{ $slot }}
                @break

            @default
                <input
                    wire:model{{ $live ? '.live' : '' }}{{ $blur ? '.blur' : '' }}="{{ $field }}"
                    name="{{ $field }}"
                    type="{{ $type }}"
                    class="{{ $inputClasses }}"
                    placeholder="{{ $placeholder ?? '' }}"
                    {{ $attributes->only($inputAttrs) }}
                    @if($isDisabled) disabled="disabled" @endif
                />
                @break
        @endswitch
    </div>

    @error($errorFor ?: $field)
        <span class="block text-red-500">{{ $message }}</span>
    @elseif($help)
        <span class="block text-gray-500 text-sm">{!! $help !!}</span>
    @enderror
</div>
