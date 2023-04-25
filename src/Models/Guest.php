<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Quepenny\Livewire\Traits\Models\UserTrait;

class Guest extends Model
{
    use HasUlids;
    use UserTrait;

    public function uniqueIds(): array
    {
        return ['token'];
    }
}
