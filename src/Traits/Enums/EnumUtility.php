<?php

namespace Quepenny\Livewire\Traits\Enums;

trait EnumUtility
{
    public static function dropdownOptions(string $placeholder = '', array $additional = []): array
    {
        return enum_dropdown_options(self::cases(), $placeholder, $additional);
    }
}
