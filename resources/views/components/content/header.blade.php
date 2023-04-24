@props([
    'actionButtonText' => '',
    'buttonAction' => '',
    'canSearch' => true,
    'counter' => '',
    'destructiveActionButton' => false,
    'showActionButton' => false,
    'showSearchButton' => false,
    'status' => 'info',
    'subtitle' => '',
    'title',
])

<section
    class="pt-8 px-4"
    x-data="resourceManager"
>
    @if($canSearch)
        <x-dashboard.resources.search-bar />
    @endif

    <div
        x-show="!searching"
        class="flex flex-wrap items-start sm:justify-between"
    >
        <div class="flex w-full sm:w-auto items-center mb-5 lg:mb-0">
            <div class="flex w-full lg:w-auto justify-between sm:justify-start items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-600 -mt-1">{{ $title }}</h2>
                    <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                </div>

                @if($counter)
                    <span
                        @class([
                            'inline-block py-1 px-2 ml-2 rounded-full text-xs text-white',
                            'bg-teal-500' => $status === 'info',
                            'bg-yellow-300 text-black' => $status === 'pending',
                        ])
                    >{{ $counter }}</span>
                @endif
            </div>
        </div>

        <div class="w-full flex justify-between sm:justify-end sm:w-1/2 lg:w-auto">
            @if($showActionButton)
                <x-jet-button :action="$buttonAction">
                    <span>{{ $actionButtonText }}</span>
                </x-jet-button>
            @endif

            <div class="flex relative inline-block text-left ml-auto sm:ml-2">
                @if($canSearch && $showSearchButton)
                    <button
                        class="ring-1 ring-black ring-opacity-5 p-3 mr-2 bg-teal-500 rounded"
                        @click="openSearch"
                    >
                        <x-icon
                            name="search-heart-fill"
                            class="h-4 w-4 text-white"
                        />
                    </button>
                @endif

                @if($slot->isNotEmpty())
                    <x-dropdown.list>
                        <x-slot name="toggle">
                            <button
                                class="ring-1 ring-black ring-opacity-5 p-3 bg-white rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-teal-500"
                                @click="toggleDropdown"
                            >
                                <x-icon
                                    name="three-dots"
                                    class="h-4 w-4 text-teal-500"
                                />
                            </button>
                        </x-slot>

                        {{ $slot }}
                    </x-dropdown.list>
                @endif
            </div>
        </div>
    </div>
</section>
