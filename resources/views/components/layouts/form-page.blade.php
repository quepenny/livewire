<x-layouts.app
    title="{{ $pageTitle ?? $mainTitle }}"
    :show-header-footer="false"
>
    <section class="py-10 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto">
                <div class="mb-10 text-center">
                    <x-logo/>
                </div>

                <div class="mb-6 lg:mb-10 p-6 lg:p-12 bg-white shadow rounded">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">{{ $mainTitle ?? '' }}</h3>
                        <p class="text-gray-500">{{ $subTitle ?? '' }}</p>
                    </div>

                    <form method="POST" action="{{ $formAction }}">
                        @csrf

                        {{ $slot }}

                        <div class="text-center">
                            <button class="mb-4 w-full py-4 bg-teal-600 hover:bg-teal-700 rounded text-sm font-bold text-gray-50">
                                {{ $buttonText ?? $mainTitle }}
                            </button>

                            {{ $formFooter ?? '' }}
                        </div>
                    </form>

                    {{ $footer ?? '' }}
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
