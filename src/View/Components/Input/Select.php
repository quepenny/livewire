<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

class Select extends FormInput
{
    public string $type = 'select';

    #[Computed]
    public function options(): array
    {
        return $this->attributes->get('options', []);
    }

    public function render(): View
    {
        return view('components.input.select');
    }
}
