<?php

namespace Quepenny\Livewire\Traits\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;

trait MorphTrait
{
    public function morphManyThrough(
        $related,
        $through,
        $morphName,
        $firstKey = null,
        $secondKey = null,
        $localKey = null,
        $secondLocalKey = null,
    ): HasManyThrough {
        $firstKey = $firstKey ?? "{$morphName}_id";

        return $this->hasManyThrough(
            $related, $through, $firstKey, $secondKey, $localKey, $secondLocalKey
        )->where("{$morphName}_type", $this->morph_type);
    }

    public function getMorphTypeAttribute(): string
    {
        return array_search(static::class, Relation::morphMap()) ?: static::class;
    }
}
