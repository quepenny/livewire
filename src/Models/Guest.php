<?php

namespace App\Models;

use App\Traits\Models\UserTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasUlids;
    use UserTrait;

    public function uniqueIds(): array
    {
        return ['token'];
    }
}
