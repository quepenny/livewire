<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;

class Settings extends PageComponent
{
    public function render(): View
    {
        return view('quepenny::livewire.settings')->layoutData([
            'title' => __('pages.settings.title') ?: 'Settings',
            'nav' => ['active' => 'settings'],
        ]);
    }
}
