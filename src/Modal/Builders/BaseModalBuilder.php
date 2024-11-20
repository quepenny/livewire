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

    public static function slug(): string
    {
        return Str::of(class_basename(static::class))
            ->replace('Builder', '')
            ->kebab()
            ->prepend('quepenny::livewire.modal.');
    }

    public static function modalClass(): string
    {
        $modalBasename = Str::of(static::class)
            ->classBasename()
            ->replace('Builder', '');

        return Str::of(static::class)
            ->replace('Builders\\' . class_basename(static::class), $modalBasename);
    }
}
