<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Privacy extends PageComponent
{
    #[Title('Privacy')]
    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.privacy')->layoutData([
            'nav' => ['active' => 'privacy'],
        ]);
    }
}
