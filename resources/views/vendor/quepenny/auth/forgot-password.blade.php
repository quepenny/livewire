<x-layouts.form-page
    :page-title="__('Reset Password')"
    :main-title="__('Forgot Your Password?')"
    :sub-title="__('quepenny::auth.forgot-password')"
    :form-action="route('password.email')"
    :button-text="__('Reset Password')"
>
    @if(session()->has('status'))
        <div
            class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 mb-6"
            role="alert"
        >
            <p class="font-bold">Sent!</p>
            <p>{{ session()->get('status') }}</p>
        </div>
    @endif
    
    <x-input
        field="email"
        type="email"
        value="{{ old('email') }}"
    />

    <x-slot name="formFooter">
        <a
            class="text-xs text-teal-600 hover:underline"
            href="{{ route('login') }}"
        >{{ __('Remember Now?') }}</a>
    </x-slot>
</x-layouts.form-page>