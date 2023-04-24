@props([
    'name',
    'color' => 'currentColor',
    'width' => 32,
    'height' => 32,
])

<svg
    class="bi {{ $attributes->get('class') }}"
    width="{{ $width }}"
    height="{{ $height }}"
    fill="{{ $color }}"
    {{ $attributes->except('class') }}
>
    <use xlink:href="{{ asset('icon/bootstrap-icons.svg#') . $name }}"/>
</svg>
