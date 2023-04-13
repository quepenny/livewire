<?php

namespace Quepenny\Livewire\View\Components;

use Quepenny\Livewire\Traits\ComputesProps;
use Quepenny\Livewire\Traits\Makeable;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    use ComputesProps;
    use Makeable;

    public function toHtml(): string
    {
        return $this->render()
            ->with($this->data())
            ->render();
    }
}
