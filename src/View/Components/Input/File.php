<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\Traits\ComputesProps;

/**
 * @property-read string $icon
 */
class File extends FormInput
{
    use ComputesProps;

    public string $type = 'file';

    public function mount(): void
    {
        $this->inputAttributes['accept'] = 'image/*';
    }

    #[Computed]
    public function icon(): string
    {
        return $this->attributes->get('icon', 'file-earmark-arrow-up');
    }

    public function render(): View
    {
        return view('components.input.file');
    }
}
