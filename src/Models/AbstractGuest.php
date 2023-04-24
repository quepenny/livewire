<?php

namespace Quepenny\Livewire\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractGuest extends Model
{
    use HasUlids;

    abstract public function hasData(): bool;

    public function uniqueIds(): array
    {
        return ['token'];
    }
}
