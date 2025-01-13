<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;

class Privacy extends PageComponent
{
    public function render(): View
    {
        return view('livewire.privacy')->layoutData([
            'title' => __('quepenny::legal.privacy.title'),
            'nav' => ['active' => 'privacy'],
        ]);
    }
}
