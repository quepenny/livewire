<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;

class Textarea extends FormInput
{
    public string $type = 'textarea';

    protected function cssClasses(): array
    {
        return [
            'h-24',
            ...parent::cssClasses(),
        ];
    }

    public function render(): View
    {
        return view('components.input.textarea');
    }
}
