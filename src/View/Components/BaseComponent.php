<?php

namespace Quepenny\Livewire\View\Components;

use Illuminate\View\Component;
use Quepenny\Livewire\Traits\ComputesProps;
use Quepenny\Livewire\Traits\Makeable;

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
