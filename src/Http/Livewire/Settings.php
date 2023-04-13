<?php

namespace Quepenny\Livewire\Http\Livewire;

use Illuminate\Contracts\View\View;

class Settings extends PageComponent
{
    public function render(): View
    {
        return view('livewire.settings')->layoutData([
            'title' => 'Settings',
            'nav' => ['active' => 'settings'],
        ]);
    }
}
