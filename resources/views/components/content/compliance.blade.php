@props([
    'title',
    'lastUpdated'
])

<x-content.title-subtitle
    :title="$title"
    :subtitle="__('quepenny::legal.last_updated', ['date' => $lastUpdated])"
>
    <div class="compliance">
        {{ $slot }}
    </div>
</x-content.title-subtitle>
