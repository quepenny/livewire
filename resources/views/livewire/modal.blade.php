<aside>
    @if($showHeader)
        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
            <header>
                <h1 class="block text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $this->title }}
                </h1>

                @if($this->subtitle)
                    <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                        {{ $this->subtitle }}
                    </p>
                @endif
            </header>

            @if($showExitCross)
                <button
                    type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="defaultModal"
                    wire:click="cancel"
                >
                    <x-bs-icon name="x" />
                </button>
            @endif
        </div>
    @endif

    @if($this->body)
        <div class="p-6 space-y-6">
            {{ $this->body }}
        </div>
    @endif

    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        @if($showConfirmButton)
            <x-button
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                action="confirm"
                :destructive-action-button="$destructiveAction"
            >
                {{ $this->confirmText }}
            </x-button>
        @endif

        @foreach($this->customActions as $action)
            <x-button
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                action="executeAction('{{ $action['name'] }}')"
                :show-color="false"
            >
                {{ $action['label'] }}
            </x-button>
        @endforeach

        @if($showCancelButton)
            <x-button
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                action="cancel"
                :show-color="false"
            >
                {{ $this->cancelText }}
            </x-button>
        @endif
    </div>
</aside>