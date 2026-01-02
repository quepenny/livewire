<x-layouts.form-page
    :main-title="__('Sign Up')"
    :sub-title="__('Create an Account')"
    :form-action="route('register')"
>
    @include('quepenny::auth.disclaimer-data-transfer')

    <x-social-login />

    <x-input.text
        field="name"
        value="{{ old('name') }}"
    />

    <x-input.text
        field="email"
        type="email"
        value="{{ old('email') }}"
    />

    <x-input.text
        field="password"
        type="password"
    />

    <x-input.text
        :label="__('Confirm Password')"
        field="password_confirmation"
        type="password"
    />

    @if (\Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <p class="mb-2">
            {{ __('I agree to') }}

            <a
                target="_blank"
                href="{{ route('terms') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >{{ __('Terms of Use') }}</a>

            <a
                target="_blank"
                href="{{ route('privacy') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >{{ __('Privacy Policy') }}</a>
        </p>

        <x-input.checkbox
            label="Agreed"
            field="terms"
        />
    @endif

    <x-slot name="formFooter">
        <span class="text-gray-400 text-xs">
            <span>{{ __('Already have an account?') }}</span>

            <a
                class="text-teal-600 hover:underline"
                href="{{ route('login') }}"
            >{{ __('Sign In') }}</a>
        </span>
    </x-slot>
</x-layouts.form-page>
