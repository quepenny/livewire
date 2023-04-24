@props([
    'section', // e.g. item, list, stock-check
    'showSubtitle' => true,
    'showButton' => true,
    'action' => '',
])

<section class="container mx-auto py-12">
    <div class="flex flex-col items-center text-center text-gray-400">
        <x-icon
            :name="$icon ?? 'inboxes-fill'"
            width="80"
            height="80"
        />
        
        <h2 class="my-5 text-2xl text-gray-400 font-bold capitalize">{{ __("empty.{$section}.title") }}</h2>
    
        @if($showSubtitle)
            <p class="mb-8 text-gray-400">{{ __("empty.{$section}.subtitle") }}</p>
        @endif
        
        @if($showButton)
            <x-jet-button
                class="capitalize mb-2 inline-block py-1 px-3 rounded-l-xl rounded-t-xl font-bold leading-loose text-gray-50 bg-teal-500 hover:bg-teal-600"
                :action="$action"
            >
                {{ __("empty.{$section}.button_text") }}
            </x-jet-button>
        @endif
    </div>
</section>
