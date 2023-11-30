<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Quepenny\Livewire\BaseComponent;

class Tooltip extends BaseComponent
{
    public string $key = '';

    public function __construct(
        public string $message,
        public string $placement = 'top',
        public string $tag = 'div'
    ) {
        $this->key = Str::uuid();
    }

    public function render(): View
    {
        return view('components.tooltip');
    }
}
