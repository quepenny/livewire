<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <x-input.text
            class="col-span-6"
            field="state.current_password"
            type="password"
            error-for="current_password"
            :label="__('Current Password')"
        />
    
        <x-input.text
            class="col-span-6"
            field="state.password"
            type="password"
            error-for="password"
            :label="__('New Password')"
        />
    
        <x-input.text
            class="col-span-6"
            field="state.password_confirmation"
            type="password"
            error-for="password_confirmation"
            :label="__('Confirm Password')"
        />
    </x-slot>

    <x-slot name="actions">
        <x-jet-button
            x-data=""
            x-init="$wire.on('saved', () => $store.toast.success('Saved'))"
        >
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
