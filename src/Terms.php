<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Terms extends PageComponent
{
    #[Title('Terms Of Service')]
    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.terms')->layoutData([
            'nav' => ['active' => 'terms'],
        ]);
    }
}
