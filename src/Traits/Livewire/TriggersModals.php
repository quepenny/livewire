<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;
use Quepenny\Livewire\Http\Livewire\Modal\BaseModalComponent;
use Quepenny\Livewire\Http\Livewire\Modal\Builders\BaseModalBuilder;

trait TriggersModals
{
    protected function getListeners(): array
    {
        $this->listeners[] = '$refresh';

        return $this->listeners;
    }

    public function modal(
        BaseModalComponent|BaseModalBuilder $modal,
        array $params = []
    ): void {
        if ($modal instanceof Arrayable) {
            $params = $modal->toArray();
        }

        $this->emit('openModal', 'modal.'.$modal->slug(), $params);
        // For opening modals on page component mount
        Session::flash('open-modal', [
            'modal' => 'modal.'.$modal->slug(),
            'params' => $params,
        ]);
    }
}
