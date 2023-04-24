<?php

namespace Quepenny\Livewire\Traits\Models;

trait UserTrait
{
    use MorphTrait;

    abstract public function hasData(): bool;
}
