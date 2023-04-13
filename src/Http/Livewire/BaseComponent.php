<?php

namespace Quepenny\Livewire\Http\Livewire;

use Quepenny\Livewire\Traits\Livewire\Toastable;
use Quepenny\Livewire\Traits\Livewire\TriggersModals;
use Quepenny\Livewire\Traits\Livewire\ValidatesInput;
use Livewire\Component;

abstract class BaseComponent extends Component
{
    use Toastable;
    use TriggersModals;
    use ValidatesInput;
}
