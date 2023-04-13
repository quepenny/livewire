<?php

namespace Quepenny\Livewire\View\Components;

abstract class PageComponent extends BaseComponent
{
    public function __construct(
        public string $title = ''
    ) {
    }
}
