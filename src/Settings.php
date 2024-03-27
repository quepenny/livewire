<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Settings extends PageComponent
{
    #[Title('Settings')]
    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.settings');
    }
}
