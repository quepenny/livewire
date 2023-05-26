<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Quepenny\Livewire\View\Components\PageComponent;

class AppLayout extends PageComponent
{
    public function render(): View
    {
        return view('components.layouts.app');
    }
}
