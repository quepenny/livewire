<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\View\Components\BaseComponent;

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
        public string $errorFor = '',
        public bool $showLabel = true,
        public string $placeholder = '',
        public bool $live = false,
        public bool $blur = false,
        public bool $slim = false,
        public bool $isDisabled = false,
    ) {}

    #[Computed]
    public function cssClasses(): string
    {
        return '
            border
            border-gray-200
            text-gray-900
            text-sm
            rounded-lg
            focus:ring-blue-500
            focus:border-blue-500
            p-2.5
            dark:bg-gray-600
            dark:border-gray-500
            dark:placeholder-gray-400
            dark:text-white
        ';
    }

    #[Computed]
    public function inputClasses(): string
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
