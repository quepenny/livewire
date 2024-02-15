@livewire('livewire-ui-modal')

@if (session()->has('open-modal'))
    <script>
        const modal = @json(session('open-modal'));

        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('openModal', {
                component: modal.component,
                arguments: modal.arguments
            });
        })
    </script>

    @php
        session()->forget('open-modal');
    @endphp
@endif
