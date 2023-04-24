<{{ $tag ?? 'div' }}
    {{ $attributes->except('tag') }}
>
    {{ $slot }}
</{{ $tag ?? 'div' }}>