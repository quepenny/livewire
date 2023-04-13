<?php

namespace Quepenny\Livewire\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasUlids;

    public function uniqueIds(): array
    {
        return ['token'];
    }
}
