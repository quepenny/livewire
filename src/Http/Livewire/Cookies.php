<?php

namespace Quepenny\Livewire\Http\Livewire;

use Illuminate\Contracts\View\View;

class Cookies extends PageComponent
{
    public function render(): View
    {
        return view('livewire.cookies')->layoutData([
            'title' => 'Cookie Policy',
            'nav' => ['active' => 'cookies'],
        ]);
    }
}
