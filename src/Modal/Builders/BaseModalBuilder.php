<?php

namespace Quepenny\Livewire\Modal\Builders;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Quepenny\Livewire\Traits\Makeable;
use Quepenny\Livewire\Traits\Metable;

abstract class BaseModalBuilder implements Arrayable
{
    use Makeable;
    use Metable;

    final public static function slug(): string
    {
        return once(fn () => 'modal.'.Str::snake(
            str_replace('Builder', '', class_basename(static::class)),
            '-'
        ));
    }
}
