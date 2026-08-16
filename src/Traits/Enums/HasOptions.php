<?php

namespace Quepenny\Livewire\Traits\Enums;

trait HasOptions
{
    public function label(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value ?? $this->name;
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value(), self::cases());
    }

    public static function dropdownOptions(string $placeholder = '', array $additional = []): array
    {
        return enum_dropdown_options(self::cases(), $placeholder, $additional);
    }

    /**
     * Options for inputs that lay every choice out at once. Unlike a dropdown these
     * carry no empty placeholder, because there is nothing to open past.
     *
     * @return array<int, array{value: string, label: string}>
     */
    public static function choiceOptions(): array
    {
        return array_map(fn (self $case) => [
            'value' => $case->value(),
            'label' => $case->label(),
        ], self::cases());
    }
}
