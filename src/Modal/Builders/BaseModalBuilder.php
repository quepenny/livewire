<?php

namespace Quepenny\Livewire\Modal\Builders;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Quepenny\Livewire\Traits\Makeable;
use Quepenny\Livewire\Traits\Metable;

abstract class BaseModalBuilder implements Arrayable
{
    use Metable;
    use Makeable;

    public static string $modalSlug = '';

    final public static function slug(): string
    {
        return once(self::$modalSlug, fn () => Str::snake(
            str_replace('Builder', '', class_basename(static::class)),
            '-'
        ));
    }
}
