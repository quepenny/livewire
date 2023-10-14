<x-form-page
    :main-title="__('Reset Password')"
    :form-action="route('password.update')"
    :button-text="__('Reset Password')"
>
    <input
        type="hidden"
        name="token"
        value="{{ $request->route('token') }}"
    >

    <x-input
        field="email"
        type="email"
        :value="old('email', $request->email)"
    />

    <x-input
        field="password"
        type="password"
    />

    <x-input
        label="Confirm Password"
        field="password_confirmation"
        type="password"
    />
</x-form-page>