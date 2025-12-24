<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

/**
 * @property-read string $datalistId
 * @property-read array $options
 */
class Datalist extends FormInput
{
    public string $type = 'datalist';

    #[Computed]
    public function options(): array
    {
        return $this->attributes->get('options', []);
    }

    #[Computed]
    public function datalistId(): string
    {
        return "datalist-{$this->field}";
    }

    public function render(): View
    {
        return view('components.input.datalist');
    }
}
