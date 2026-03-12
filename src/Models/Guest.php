<?php

namespace App\Models;

use App\Traits\Models\IsUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasUlids;
    use IsUser;

    public function uniqueIds(): array
    {
        return ['token'];
    }
}
