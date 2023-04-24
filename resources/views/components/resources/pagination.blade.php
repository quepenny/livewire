@if($paginator->hasPages())
    <div class="flex justify-center mt-8">
        @unless($paginator->onFirstPage())
            <button
                class="lg:mb-0 mr-4 py-0.5 px-4 rounded-l-xl rounded-t-xl leading-loose text-sm text-gray-50 bg-teal-500 hover:bg-teal-600 disabled:opacity-25 transition"
                @click="previousPage"
                wire:key="back"
                wire:loading.attr="disabled"
                wire:target="previousPage"
            >
                {{ __('Back') }}
            </button>
        @endunless
    
        @unless($paginator->onLastPage())
            <button
                class="lg:mb-0 py-0.5 px-4 rounded-r-xl rounded-t-xl leading-loose text-sm text-gray-50 bg-teal-500 hover:bg-teal-600 disabled:opacity-25 transition"
                @click="nextPage"
                wire:key="next"
                wire:loading.attr="disabled"
                wire:target="nextPage"
            >
                {{ __('Next') }}
            </button>
        @endunless
    </div>
@endif