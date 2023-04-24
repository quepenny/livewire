<x-content>
    <div class="container mx-auto py-8 px-4">
        <div class="mb-4">
            <h2 class="text-2xl font-bold font-heading">{{ $title }}</h2>
            <p class="text-sm text-gray-500 leading-loose">{{ $subtitle }}</p>
        </div>

        {{ $slot }}
    </div>
</x-content>
