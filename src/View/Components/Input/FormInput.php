<?php

namespace App\View\Components\Input;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\View\Components\BaseComponent;

/**
 * @property-read string $inputClasses
 */
abstract class FormInput extends BaseComponent
{
    /**
     * HTML (or other) attributes that can be added to the input tag.
     */
    public array $inputAttributes = [
        'autocomplete',
        'max',
        'min',
        'x-model',
        'value',
        'accept',
    ];

    public string $type = 'text';

    public function __construct(
        public string $field,
        public ?string $label = null,
        public string $errorFor = '',
        public bool $hideLabel = false,
        public string $placeholder = '',
        public bool $live = false,
        public bool $change = false,
        public bool $slim = false,
        public bool $disabled = false,
        public string $help = '',
        public bool $required = false,
    ) {
        $this->errorFor = $errorFor ?: $field;

        $this->mount();
    }

    public function mount(): void {}

    #[Computed]
    public function inputClasses(): string
    {
        return implode(separator: ' ', array: $this->cssClasses());
    }

    protected function cssClasses(): array
    {
        return [
            'w-full',
            'border-gray-200',
            'text-gray-900',
            'text-sm',
            'rounded-lg',
            'focus:ring-blue-500',
            'focus:border-blue-500',
            'p-2.5',
            'dark:bg-gray-600',
            'dark:border-gray-500',
            'dark:placeholder-gray-400',
            'dark:text-white',
        ];
    }

    public function render(): View
    {
        return view('components.input.text');
    }
}
