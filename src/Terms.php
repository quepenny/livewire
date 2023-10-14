<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;

class Terms extends PageComponent
{
    public function render(): View
    {
        return view('livewire.terms')->layoutData([
            'title' => 'Terms of Service',
            'nav' => ['active' => 'terms'],
        ]);
    }
}
