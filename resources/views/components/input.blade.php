@props([
    'disabled' => false,
])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'w-full py-3 pl-3 bg-white border border-neutral-200 text-black placeholder-neutral-400 rounded-lg transition duration-200 hover:border-primary focus:outline-none focus:ring-primary focus:border-primary',
    ]) }}
/>
