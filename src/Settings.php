<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Settings extends PageComponent
{
    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.settings')->layoutData([
            'title' => __('pages.settings.title') ?: 'Settings',
            'nav' => ['active' => 'settings'],
        ]);
    }
}
