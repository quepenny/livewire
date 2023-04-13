<?php

namespace Quepenny\Livewire\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * @property-read string $inputClasses
 * @property-read string $cssClasses
 */
class Input extends BaseComponent
{
    public array $inputAttrs = [
        'x-model',
        'value',
        'autocomplete',
    ];

    public function __construct(
        public string $field,
        public ?string $label = null,
        public array|Collection $options = [],
        public string $type = 'text',
        public string $errorFor = ''
    ) {
    }

    public function getCssClassesProperty(): string
    {
        return "
            bg-gray-50
            border
            border-gray-300
            text-gray-900
            text-sm
            rounded-lg
            focus:ring-teal-500
            focus:border-teal-500
            p-2.5
            dark:bg-gray-600
            dark:border-gray-500
            dark:placeholder-gray-400
            dark:text-white
        ";
    }

    public function getInputClassesProperty(): string
    {
        return $this->cssClasses . match ($this->type) {
            'checkbox' => 'ml-2 w-6 h-6',
            default => 'w-full',
        };
    }

    public function render(): View
    {
        return view('components.input');
    }
}
