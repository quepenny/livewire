<x-layouts.form-page
    :main-title="__('Sign In')"
    :sub-title="__('Shop With Us')"
    :form-action="route('login')"
>
    @error('login-error')
        <p class="text-red-500 text-sm -mt-3 mb-6">
            {{ $message }}
        </p>
    @enderror

    @include('quepenny::auth.disclaimer-data-transfer')

    <x-social-login />

    <x-input.text
        field="email"
        type="email"
        value="{{ old('email') }}"
    />

    <x-input.text
        field="password"
        type="password"
        value="{{ old('password') }}"
    />

    <x-input.checkbox
        label="{{ __('Remember Me') }}"
        field="remember"
        checked="{{ old('remember') }}"
    />

    <x-slot name="formFooter">
        <p class="text-gray-400 text-xs w-full">
            <span>{{ __('New to :app_name?', ['app' => env('APP_NAME')]) }}</span>

            <a
                class="text-teal-600 hover:underline"
                href="{{ route('register') }}"
            >{{ __('Sign Up') }}</a>
        </p>

        <a
            class="text-xs text-teal-600 hover:underline"
            href="{{ route('password.request') }}"
        >{{ __('Forgot password?') }}</a>
    </x-slot>
</x-layouts.form-page>
