<div
    class="mb-3 {{ $attributes->get('class') }}"
    {{ $attributes->except($inputAttrs) }}
>
    <label class="text-gray-700 text-sm font-bold" for="username">
        {{ $label ?? __(ucfirst($field)) }}
    </label>
    
    <div
        @class([
            'mt-2',
            'inline-block' => $type === 'checkbox'
        ])
    >
        @switch($type)
            @case('select')
                <select
                    wire:model="{{ $field }}"
                    name="{{ $field }}"
                    {{ $attributes->only($inputAttrs) }}
                    class="{{ $prop('inputClasses') }}"
                >
                    <option value="">{{ __('Select') }}</option>
                
                    @foreach($options as $option)
                        <option value="{{ $option['value'] }}">
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
                @break
        
            @case('textarea')
                <textarea
                    wire:model="{{ $field }}"
                    name="{{ $field }}"
                    {{ $attributes->only($inputAttrs) }}
                    @class([$prop('inputClasses'), 'h-24'])
                ></textarea>
                @break
        
            @case('custom')
                {{ $slot }}
                @break
        
            @default
                <input
                    wire:model="{{ $field }}"
                    name="{{ $field }}"
                    type="{{ $type }}"
                    class="{{ $prop('inputClasses') }}"
                    {{ $attributes->only($inputAttrs) }}
                />
                @break
        @endswitch
    </div>
    
    @error($errorFor ?: $field)
        <span class="block text-red-500">{{ $message }}</span>
    @enderror
</div>