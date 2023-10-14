@livewire('livewire-ui-modal')

@if (session()->has('open-modal'))
    <script>
        let modal = @json(session('open-modal'));

        document.addEventListener('livewire:init', () => {
            Livewire.dispatch('openModal', {
                component: modal.component,
                arguments: modal.arguments
            });
        })
    </script>
@endif
