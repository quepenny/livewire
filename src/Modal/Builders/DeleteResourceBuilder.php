<?php

namespace Quepenny\Livewire\Modal\Builders;

class DeleteResourceBuilder extends EditResourceBuilder
{
    public function __construct(
        string $model,
        int|string $id = 0,
        string $title = ''
    ) {
        parent::__construct($model, $id, $title);
        $this->lazyLoadResource();
    }
}
