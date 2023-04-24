<div class="relative w-full h-1 mb-3 rounded-full bg-gray-200 {{ $attributes->get('class') }}">
    <div
        @class([
            'absolute top-0 left-0 h-full rounded-full',
            'bg-teal-500' => $item->progress <= 50,
            'bg-yellow-300' => $item->progress > 50 && $item->progress <= 75,
            'bg-red-500' => $item->progress > 75,
        ])
        style="width: {{ min($item->progress, 100) }}%"
    ></div>
</div>