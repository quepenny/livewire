<?php

namespace Quepenny\Livewire\Traits\Models;

trait Wrappable
{
    public static function wrap(mixed $model): ?static
    {
        if (!$model || $model instanceof static) {
            return $model;
        }

        return static::find($model);
    }
}
