<?php

namespace Quepenny\Livewire\View\Components;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

/**
 * @property-read int $iconSize
 */
class Button extends BaseComponent
{
    public string $tag;

    public array $resolvedVariant;

    public function __construct(
        public ?string $action = null,
        public string $variant = 'teal',
        public string $textSize = 'text-base',
        public string $font = '',
        public string $icon = '',
        public string $link = '',
        public string $padding = 'py-2 px-5',
        public string $rounding = 'rounded-lg',
        public string $disabledVariant = '',
        public bool $hideBackground = false,
    ) {
        $this->resolveTag();
        $this->resolveVariants();
    }

    private function resolveTag(): void
    {
        $this->tag = $this->link || $this->hideBackground ? 'a' : 'button';
    }

    private function resolveVariants(): void
    {
        $variants = config('quepenny.button_variants');

        $this->resolvedVariant = $variants[$this->variant] ?? $variants['teal'];
        $this->resolvedVariant['background'] ??= '';

        $this->disabledVariant = $this->disabledVariant ?: $this->variant;
        $disabledVariant = $variants[$this->disabledVariant] ?? [];

        $this->resolvedVariant['disabledBackground'] = $disabledVariant['disabledBackground'] ?? 'disabled:bg-transparent';
        $this->resolvedVariant['disabledBorder'] = $disabledVariant['disabledBorder'] ?? 'disabled:border-gray-200';
        $this->resolvedVariant['disabledText'] = $disabledVariant['disabledText'] ?? 'disabled:text-gray-400';
    }

    #[Computed]
    public function iconSize(): int
    {
        return match ($this->textSize) {
            'text-xs' => 12,
            'text-sm' => 14,
            'text-base' => 16,
            'text-xl' => 20,
            'text-2xl' => 24,
            default => 18,
        };
    }

    public function render(): View
    {
        return view('components.button');
    }
}
