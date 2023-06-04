@props(['tag' => 'div'])

<{{ $tag }} {{ $attributes->except('tag') }}>
    {{ $slot }}
</{{ $tag }}>
