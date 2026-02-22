<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;
use Quepenny\Livewire\Modal\BaseModalComponent;
use Quepenny\Livewire\Modal\Builders\BaseModalBuilder;

trait TriggersModals
{
    protected function getListeners(): array
    {
        $this->listeners[] = '$refresh';

        return $this->listeners;
    }

    public function modal(BaseModalComponent|BaseModalBuilder $modal, array $params = []): void
    {
        if ($modal instanceof Arrayable) {
            $params = $modal->toArray();
        }

        $this->dispatch('openModal', $modal->slug(), $params);

        // For opening modals on the page component mount
        Session::now('open-modal', [
            'component' => $modal->slug(),
            'arguments' => $params,
        ]);
    }
}
