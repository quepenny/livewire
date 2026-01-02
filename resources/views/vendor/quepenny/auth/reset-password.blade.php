<x-layouts.form-page
    :main-title="__('Reset Password')"
    :form-action="route('password.update')"
    :button-text="__('Reset Password')"
>
    <input
        type="hidden"
        name="token"
        value="{{ $request->route('token') }}"
    >

    <x-input.text
        field="email"
        type="email"
        :value="old('email', $request->email)"
    />

    <x-input.text
        field="password"
        type="password"
    />

    <x-input.text
        label="Confirm Password"
        field="password_confirmation"
        type="password"
    />
</x-layouts.form-page>