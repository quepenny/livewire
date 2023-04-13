<?php

namespace Quepenny\Livewire\Actions;

use Quepenny\Livewire\Traits\Makeable;

abstract class BaseAction
{
    use Makeable;

    abstract public function handle();
}