<?php

namespace App\Traits\Models;

use Quepenny\Livewire\Traits\Models\MorphTrait;

trait UserTrait
{
    use MorphTrait;

    public function getHasDataAttribute(): bool
    {
        return true;
    }
}
