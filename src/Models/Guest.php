<?php

namespace App\Models;

use Quepenny\Livewire\Models\AbstractGuest;

class Guest extends AbstractGuest
{
    public function hasData(): bool
    {
        return false;
    }
}
