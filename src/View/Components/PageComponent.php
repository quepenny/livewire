<?php

namespace Quepenny\Livewire\View\Components;

abstract class PageComponent extends BaseComponent
{
    public function __construct(
        public string $title,
        public array $nav = [],
        public bool $showHeaderFooter = true
    ) {
    }
}
