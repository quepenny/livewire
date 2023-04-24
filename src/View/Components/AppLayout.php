<?php

namespace Quepenny\Livewire\View\Components;

use Illuminate\Contracts\View\View;

class AppLayout extends PageComponent
{
    public function render(): View
    {
        return view('components.layouts.app');
    }
}
