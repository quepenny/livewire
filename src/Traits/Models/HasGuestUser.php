<?php

namespace Quepenny\Livewire\Traits\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Quepenny\Livewire\Enums\UserType;

trait HasGuestUser
{
    public function casts(): array
    {
        return [ 'user_type' => UserType::class ];
    }

    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    #[Scope]
    public function forCurrentUser(Builder $query): void
    {
        $query->where([
            'user_id' => user()->getKey(),
            'user_type' => user()->morph_type,
        ]);
    }
}
