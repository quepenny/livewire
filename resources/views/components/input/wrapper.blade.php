@props([
    'type' => '',
    'required' => '',
    'field' => '',
    'label' => null,
    'errorFor' => '',
    'hideLabel' => false,
    'slim' => false,
    'help' => '',
    'hideError' => false,
    'inputAttributes' => [],
])

<div
    @class([
        $attributes->get('class'),
        'mb-3' => !$slim
    ])
    {{ $attributes->except($inputAttributes) }}
>
    @unless($hideLabel)
        <label
            class="text-gray-700 font-bold"
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
        {{ $slot }}
    </div>

    @unless($hideError)
        @error($errorFor)
            <span class="block text-red-500 mt-2">{{ $message }}</span>
        @elseif($help)
            <span class="block text-gray-500 text-sm mt-2">{!! $help !!}</span>
        @enderror
    @endunless
</div>
