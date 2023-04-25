<?php

namespace Quepenny\Livewire\Traits\Models;

trait UserTrait
{
    use MorphTrait;

    public function hasData(): bool
    {
        return true;
    }
}
