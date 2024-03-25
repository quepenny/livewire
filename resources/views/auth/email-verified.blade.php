<x-layouts.form-page
    :main-title="__('pages.email_verified.title')"
    :sub-title="__('pages.email_verified.subtitle')"
    :form-action="route('exams.index')"
    :button-text="__('pages.email_verified.button_text')"
>
    <x-slot name="footer">
        <a
            href="{{ route('profile.show') }}"
            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        >
            {{ __('pages.email_verified.edit_profile') }}
        </a>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf

            <button
                type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ml-2"
            >
                {{ __('pages.email_verified.log_out') }}
            </button>
        </form>
    </x-slot>
</x-layouts.form-page>
