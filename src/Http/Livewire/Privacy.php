<?php

namespace Quepenny\Livewire\Http\Livewire;

use Illuminate\Contracts\View\View;

class Privacy extends PageComponent
{
    public function render(): View
    {
        return view('livewire.privacy')->layoutData([
            'title' => 'Privacy',
            'nav' => ['active' => 'privacy'],
        ]);
    }
}
