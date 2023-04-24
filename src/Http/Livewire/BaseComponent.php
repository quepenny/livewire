<?php

namespace Quepenny\Livewire\Http\Livewire;

use Livewire\Component;
use Quepenny\Livewire\Traits\Livewire\Toastable;
use Quepenny\Livewire\Traits\Livewire\TriggersModals;
use Quepenny\Livewire\Traits\Livewire\ValidatesInput;

abstract class BaseComponent extends Component
{
    use Toastable;
    use TriggersModals;
    use ValidatesInput;
}
