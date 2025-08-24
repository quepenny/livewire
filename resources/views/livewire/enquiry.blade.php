<main>
    @if($submitted)
        <div class="p-4 bg-green-100 border-l-4 border-green-500">
            <p class="text-green-700">
                {{ __('quepenny::enquiry.success_message') }}
            </p>
        </div>
    @else
        <x-form.input
                field="form.subject"
                field="form.subject"
                label="{{ __('quepenny::enquiry.labels.subject') }}"
        />

        <x-form.input
                field="form.name"
                label="{{ __('quepenny::enquiry.labels.name') }}"
        />

        <x-form.input
                field="form.email"
                type="email"
                label="{{ __('quepenny::enquiry.labels.email') }}"
        />

        <x-form.input
                field="form.message"
                type="textarea"
                label="{{ __('quepenny::enquiry.labels.message') }}"
        />

        <p class="mb-2 text-xs">
            {{ __('I agree to') }}

            <a
                    target="_blank"
                    href="{{ route('terms') }}"
                    class="underline text-gray-600 hover:text-gray-900"
            >
                {{ __('Terms of Use') }}
            </a>

            and

            <a
                    target="_blank"
                    href="{{ route('privacy') }}"
                    class="underline text-gray-600 hover:text-gray-900"
            >
                {{ __('Privacy Policy') }}
            </a>
        </p>

        <x-form.input
                field="form.terms"
                type="checkbox"
                label="{{ __('quepenny::enquiry.labels.terms') }}"
        />

        <x-button
                class="w-full justify-center font-bold text-white"
                action="submit"
        >
            {{ __('quepenny::enquiry.button_text') }}
        </x-button>
    @endif
</main>
