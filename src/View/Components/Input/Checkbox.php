<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;

class Checkbox extends FormInput
{
    public string $type = 'checkbox';

    public function cssClasses(): array
    {
        // Minimise the width of the checkbox
        return array_map(
            fn ($class) => $class === 'w-full' ? 'ml-2 w-6 h-6' : $class,
            parent::cssClasses()
        );
    }

    public function render(): View
    {
        return view('components.input.checkbox');
    }
}
