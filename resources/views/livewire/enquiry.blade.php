<x-content>
    <div class="container mx-auto py-8 px-4">
        <div class="mb-4">
            <h2 class="text-2xl font-bold font-heading">{{ __('quepenny::enquiry.title') }}</h2>
            <p class="text-gray-500 text-sm leading-loose">{{ __('quepenny::enquiry.subtitle') }}</p>
        </div>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 mb-12">
                <div class="max-w-md">
                    <form>
                        <x-input field="name"/>

                        <x-input
                            field="email"
                            type="email"
                        />

                        <x-input field="subject"/>

                        <x-input
                            field="message"
                            type="textarea"
                        />

                        <x-input
                            label="{{ __('I agree to terms and conditions.') }}"
                            field="terms"
                            type="checkbox"
                        />

                        <div class="flex justify-between items-center">
                            <button
                                class="inline-block py-2 px-6 rounded-l-xl rounded-t-xl bg-teal-600 hover:bg-teal-700 text-gray-50 font-bold leading-loose transition duration-200"
                                wire:click.prevent="submit"
                            >
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-full lg:w-1/2 mb-16 lg:mb-0">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2">
                        <h3 class="mb-2 text-2xl font-bold">Email Us</h3>
                        <p class="text-gray-500 text-sm">support@quepenny.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-content>
