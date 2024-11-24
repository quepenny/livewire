<?php

namespace Quepenny\Livewire\Traits\Models;

trait Wrappable
{
    public static function wrap(mixed $model, ?callable $resolver = null): ?static
    {
        if (! $model || $model instanceof static) {
            return $model;
        }

        $resolver = $resolver ?: fn ($model) => static::find($model);

        return $resolver($model);
    }
}
