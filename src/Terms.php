<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;

class Terms extends PageComponent
{
    public function render(): View
    {
        return view('livewire.terms')->layoutData([
            'title' => __('quepenny::legal.terms.title'),
            'nav' => ['active' => 'terms'],
        ]);
    }
}
