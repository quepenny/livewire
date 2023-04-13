<?php

namespace Quepenny\Livewire\Http\Livewire\Modal\Builders;

use Quepenny\Livewire\Traits\Makeable;
use Quepenny\Livewire\Traits\Metable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class BaseModalBuilder implements Arrayable
{
    use Metable;
    use Makeable;

    public static string $modalSlug = '';

    final public static function slug(): string
    {
        return once(self::$modalSlug, fn() => Str::snake(
            str_replace('Builder', '', class_basename(static::class)),
            '-'
        ));
    }
}
