@props([
    'title',
    'lastUpdated'
])

<x-content.title-subtitle
    :title="$title"
    :subtitle="__('Last Updated: :date', ['date' => $lastUpdated])"
>
    <div class="compliance">
        {{ $slot }}
    </div>
</x-content.title-subtitle>
