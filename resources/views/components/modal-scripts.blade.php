@livewire('livewire-ui-modal')

@if (session()->has('open-modal'))
    <script>
        let shopallyModal = @json(session('open-modal'));

        document.addEventListener('livewire:load', () => {
            Livewire.emit('openModal',
                shopallyModal.modal,
                shopallyModal.params
            );
        })
    </script>
@endif
