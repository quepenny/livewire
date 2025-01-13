<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;

class Cookies extends PageComponent
{
    public function render(): View
    {
        return view('livewire.cookies')->layoutData([
            'title' => __('quepenny::legal.cookies.title'),
            'nav' => ['active' => 'cookies'],
        ]);
    }
}
