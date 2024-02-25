<?php

namespace Quepenny\Livewire;

use Livewire\Component;
use Quepenny\Livewire\Traits\Livewire\Toastable;
use Quepenny\Livewire\Traits\Livewire\TriggersModals;

abstract class BaseComponent extends Component
{
    use Toastable;
    use TriggersModals;
}
