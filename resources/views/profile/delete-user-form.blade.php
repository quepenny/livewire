<x-jet-action-section>
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete your account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>
    </x-slot>
    
    <x-slot name="actions">
        <x-jet-button
            action="$emit('openModal', 'modal.delete-account')"
            :destructive-action-button="true"
        >
            {{ __('Delete Account') }}
        </x-jet-button>
    </x-slot>
</x-jet-action-section>
