<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Cookies extends PageComponent
{
    #[Title('Cookie Policy')]
    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.cookies')->layoutData([
            'nav' => ['active' => 'cookies'],
        ]);
    }
}
