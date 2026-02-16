<?php

namespace Quepenny\Livewire\Traits\Enums;

trait EnumUtility
{
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function dropdownOptions(string $placeholder = '', array $additional = []): array
    {
        return enum_dropdown_options(self::cases(), $placeholder, $additional);
    }
}
