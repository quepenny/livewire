<?php

namespace Quepenny\Livewire\Traits;

use Illuminate\Support\Arr;

trait Metable
{
    /**
     * The meta-data for the element.
     */
    public array $meta = [];

    public function meta(string $key = null): mixed
    {
        return $key ? Arr::get($this->meta, $key) : $this->meta;
    }

    public function withMeta(array $meta): static
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }
}
