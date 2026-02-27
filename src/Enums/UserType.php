<?php

namespace Quepenny\Livewire\Enums;

use Quepenny\Livewire\Traits\Enums\EnumUtility;

enum UserType: string {
    use EnumUtility;

    case MEMBER = 'member';
    case GUEST = 'guest';
}
